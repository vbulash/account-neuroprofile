<?php

namespace App\Http\Controllers\Auth;

// use App\Events\ToastEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use \Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller {
	/**
	 * Display the login view.
	 *
	 * @return View
	 */
	public function create(Request $request) {
		return $request->has('errors') ?
			view('auth.login', ['errors' => $request->errors]) :
			view('auth.login');
	}

	/**
	 * Handle an incoming authentication request.
	 *
	 * @param LoginRequest $request
	 * @return RedirectResponse
	 */
	public function store(LoginRequest $request) {
		try {
			$request->authenticate();
			$request->session()->regenerate();
			// session()->put('success', "Вы успешно авторизовались");
			// TODO Сделать интеллектуальную проверку допустимости входа в платформу
			// if (!auth()->user()->hasRole(RoleName::ADMIN->value)) {
			//     auth()->logout();
			//     $app = env('APP_NAME');
			//     return redirect()->route('login')
			//         ->with('error', "У пользователя &laquo;{$request->email}&raquo; нет прав для входа в приложение &laquo;{$app}&raquo;");
			// }

			// Valery Bulash - intended гибко, но ненадежно - сброс сессии в неожиданных местах
			// return redirect()->intended();
			return redirect()->route('dashboard.home');
		} catch (Exception $exc) {
			return redirect()->route('login', [
				'errors' => $exc->getMessage()
			]);
		}
	}

	/**
	 * Destroy an authenticated session.
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function destroy(Request $request) {
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect()->route('login');
	}
}