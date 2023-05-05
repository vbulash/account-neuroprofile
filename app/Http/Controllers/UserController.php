<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
	public function edit(int $user) {
		$_user = User::findOrFail($user);
		$heading = sprintf("Профиль пользователя &laquo;%s&raquo;", $_user->name);

		return view('users.edit', [
			'heading' => $heading,
			'user' => $_user,
			'roles' => $_user->getRoleNames()->join("<br/>")
		]);
	}

	public function update(Request $request, int $user) {
		$data = $request->except(['_token', '_method']);
		Validator::make(
			data: $data,
			rules: [
				'name' => [
					'required',
					'string', 'max:255',
				],
				'password' => ['confirmed'],
			],
			attributes: [
				'name' => 'Фамилия, имя и отчество',
				'password' => 'Пароль',
			]
		)->validate();

		$_user = User::findOrFail($user);

		$darft = [];
		$draft['name'] = $request->name;
		$draft['email'] = $request->email;
		if ($request->has('password'))
			$draft['password'] = Hash::make($request->password);
		$_user->update($draft);

		session()->put('success', 'Профиль пользователя изменён');
		return redirect()->route('dashboard.home');
	}
}