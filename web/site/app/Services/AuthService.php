<?php
declare(strict_types=1);
namespace app\Services;

use App\Models\Admin;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class AuthService
{
    const string COOKIE_NAME = 'sl_id';

    const int COOKIE_LIFETIME = 60 * 60 * 24 * 365;

    const string SESSION_NAME = 'current_user_id';

    public function makeNewCookie(User|Admin $user): Cookie
    {
        $token = $this->generateToken($user->id, static::COOKIE_LIFETIME);

        $user instanceof Admin
            ? Log::info('Успешная авторизация', [
                'id'    => $user->id,
                'login' => $user->login,
            ])
            : Log::info('Успешная авторизация', [
                'id'   => $user->id,
                'name' => $user->name,
            ]);

        return $this->createCookie($token, static::COOKIE_LIFETIME);
    }

    public function makeLogoutCookie(): Cookie
    {
        $this->forgetAuthenticatedUser();

        return $this->createCookie('', -1);
    }

    public function forgetAuthenticatedUser(): void
    {
        Session::forget(static::SESSION_NAME);
    }

    public function getAuthenticatedUserId(): ?int
    {
        return Session::get(self::SESSION_NAME);
    }

    public function getAuthenticatedUser(): User|Admin|null
    {
        $userId = $this->getAuthenticatedUserId();

        if (!$userId) {
            return null;
        }

        $repo = app(UserRepository::class);
        $user = $repo->findById($userId);

        if ($user instanceof User || $user instanceof Admin) {
            return $user;
        }

        return null;
    }

    public function getUserIdFromRequest(Request $request): ?int
    {
        $token = $request->cookie(static::COOKIE_NAME);

        if ($token === null || !$this->validatedToken($token)) {
            return null;
        }

        $decoded = $this->decodeToken($token);

        if (empty($decoded)) {
            return null;
        }

        Session::flash(static::SESSION_NAME, $decoded['user_id']);

        return (int) $decoded['user_id'];
    }

    private function validatedToken(string $token): bool
    {
        return $this->decodeToken($token) !== null;
    }

    private function decodeToken(string $token): ?array
    {
        try {
            $decoded = json_decode(Crypt::decryptString($token), true);
        } catch (DecryptException $e) {
            return null;
        }

        if (
            empty($decoded)
            || empty($decoded['user_id'])
            || empty($decoded['expires_at'])
            || empty($decoded['salt'])
        ) {
            return null;
        }

        $expiresAt = Carbon::parse($decoded['expires_at']);

        if ($expiresAt->isPast()) {
            return null;
        }

        return $decoded;
    }

    private function createCookie(string $token, int $lifetime): Cookie
    {
        return new Cookie(
            static::COOKIE_NAME,
            $token,
            Carbon::now()->addSeconds($lifetime),
            '/',
            null,
            true,
            true,
        );
    }

    public function generateToken(int $userId, int $lifeTimeSeconds): string
    {
        $data = [
            'user_id'    => $userId,
            'expires_at' => Carbon::now()->addSeconds($lifeTimeSeconds),
            'salt'       => Str::random(32),
        ];

        return Crypt::encryptString(json_encode($data));
    }
}
