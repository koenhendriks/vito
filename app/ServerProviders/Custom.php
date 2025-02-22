<?php

namespace App\ServerProviders;

use App\ValidationRules\RestrictedIPAddressesRule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Custom extends AbstractProvider
{
    public function createValidationRules(array $input): array
    {
        return [
            'ip' => [
                'required',
                'ip',
                Rule::unique('servers', 'ip'),
                new RestrictedIPAddressesRule(),
            ],
            'port' => [
                'required',
                'numeric',
                'min:1',
                'max:65535',
            ],
        ];
    }

    public function credentialValidationRules(array $input): array
    {
        return [];
    }

    public function credentialData(array $input): array
    {
        return [];
    }

    public function data(array $input): array
    {
        return [];
    }

    public function connect(array $credentials = null): bool
    {
        return true;
    }

    public function plans(): array
    {
        return [];
    }

    public function regions(): array
    {
        return [];
    }

    public function create(): void
    {
        File::copy(
            storage_path(config('core.ssh_private_key_name')),
            Storage::disk(config('core.key_pairs_disk'))->path($this->server->id)
        );
        File::copy(
            storage_path(config('core.ssh_public_key_name')),
            Storage::disk(config('core.key_pairs_disk'))->path($this->server->id.'.pub')
        );
    }

    public function isRunning(): bool
    {
        return true;
    }

    public function delete(): void
    {
        //
    }
}
