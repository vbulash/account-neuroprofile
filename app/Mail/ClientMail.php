<?php

namespace App\Mail;

use App\Models\History;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientMail extends RespondentMail {
	public function envelope(): Envelope {
		return new Envelope(
			subject: env('BASE_NAME') . ' - результат тестирования респондента',
		);
	}

	public function content(): Content {
		return new Content(
			view: 'emails.client',
		);
	}
}