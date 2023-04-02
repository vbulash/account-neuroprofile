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

class RespondentMail extends Mailable {
	use Queueable, SerializesModels;

	public History $history;
	public Collection $blocks;
	public ?array $card;
	public Profile $profile;
	public ?object $branding;

	/**
	 * Create a new message instance.
	 */
	public function __construct(History $history, Collection $blocks, ?array $card, Profile $profile, ?object $branding) {
		$this->history = $history;
		$this->blocks = $blocks;
		$this->card = $card;
		$this->profile = $profile;
		$this->branding = $branding;
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope {
		return new Envelope(
			subject: env('APP_NAME') . ' - индивидуальный результат тестирования',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content {
		return new Content(
			view: 'emails.respondent',
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
	 */
	public function attachments(): array {
		return [];
	}
}