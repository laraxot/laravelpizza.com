<?php

declare(strict_types=1);

namespace Modules\Meetup\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Meetup\Actions\Profile\CreateOwnAssistantTokenAction;
use Modules\Meetup\Actions\Profile\ListOwnAssistantTokensAction;
use Modules\Meetup\Actions\Profile\RevokeOwnAssistantTokenAction;
use Modules\User\Models\User;

/**
 * Pagina "Collega un assistente AI" (/{lingua}/profile/assistants, CMS pages/profile/assistants.json).
 * L'utente crea e revoca da solo i token personali con cui Claude, Cursor e gli altri client MCP usano il sito
 * a suo nome (server MCP della story 7-4). La logica sta nelle Actions di Modules\Meetup\Actions\Profile.
 */
class AssistantTokens extends Component
{
    public string $name = '';

    /** Token appena creato: si mostra una volta sola e non viene mai riletto dal database. */
    public string $plainToken = '';

    public string $createdName = '';

    public string $revoked = '';

    public function create(CreateOwnAssistantTokenAction $create): void
    {
        $this->revoked = '';
        $this->validate(['name' => ['required', 'string', 'max:60']]);

        $token = $create->execute($this->user(), $this->name);
        $this->plainToken = $token['token'];
        $this->createdName = $token['name'];
        $this->name = '';
    }

    public function revoke(string $tokenId, RevokeOwnAssistantTokenAction $revoke): void
    {
        $this->plainToken = '';
        $this->revoked = $revoke->execute($this->user(), $tokenId) ? $tokenId : '';
    }

    public function dismiss(): void
    {
        $this->plainToken = '';
        $this->createdName = '';
    }

    /** @return array<string, string> */
    protected function validationAttributes(): array
    {
        return ['name' => (string) __('meetup::assistant_tokens.fields.name')];
    }

    public function render(ListOwnAssistantTokensAction $list): View
    {
        /** @var view-string $view */
        $view = 'meetup::livewire.assistant-tokens';

        return view($view, [
            'tokens' => $list->execute($this->user()),
            'mcpUrl' => url('/api/mcp'),
        ]);
    }

    private function user(): User
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        return $user;
    }
}
