<div
    x-data="initDropZone({
        _this: @this,
        rules: @js($rules),
        multiple: @js($multiple),
        uploadError: @js($uploadError),
    })"
    x-ref="element"
    @dragenter.document="handleDocumentDragenter($event)"
    @dragleave.document="handleDocumentDragleave($event)"
    @drop.document="handleDocumentDrop($event)"
    @dragover.document="handleDocumentDragOver($event, $refs.element)"
    @drop="handleDrop"
    @click="$refs.input.click()"

    class="{{ $add ? 'media-library-add' : 'media-library-replace' }}"
>
    <button
        :disabled="!isValid"
        type="button"
        :class="{
                'media-library-dropzone-drag': hasDragObject && !isDropTarget,
                'media-library-dropzone-drop': hasDragObject && isDropTarget,
            }"
        class="media-library-dropzone {{ $add ? 'media-library-dropzone-add' : 'media-library-dropzone-replace' }}">

        <input dusk="{{ $add ? 'main-uploader' : 'uploader' }}" class="media-library-hidden" x-ref="input"
               @if($multiple) multiple @endif type="file" wire:model="upload"
               @if(count($accept) !== 0) accept="{{ collect($accept)->join(',') }}" @endif
               wire:key="{{ \Illuminate\Support\Str::uuid() }}"
               x-on:livewire-upload-error="console.log('upload error')"
               x-on:livewire-upload-progress="uploadProgress = $event.detail.progress"
               x-on:livewire-upload-finish="uploadCompletedSuccessfully"
        />

        <div class="media-library-placeholder">
            <x-media-library-button wire:loading.remove x-show="isValid" level="info" icon="{{ $add ? 'add' : 'replace' }}"/>
            <x-media-library-button x-show="!isValid" level="warning" icon="not-allowed"/>

            @unless($add)
            <div class="media-library-progress-wrap" wire:target="upload" wire:loading.class="media-library-progress-wrap-loading">
                <progress max="100" :value="uploadProgress" class="media-library-progress"></progress>
            </div>
            @endunless
        </div>

        @if($add)
            <div class="media-library-progress-wrap" wire:target="upload" wire:loading.class="media-library-progress-wrap-loading">
                <progress max="100" :value="uploadProgress" class="media-library-progress"></progress>
            </div>

            <div class="media-library-help" wire:loading.remove>
                <div x-show="uploadError">
                    @if($uploadError)
                        @include('media-library::livewire.partials.item-error', ['message' => $uploadError])
                    @endif
                </div>

                <div>
                    <span x-show="isValid && hasDragObject">
                            <span x-show="!isDropTarget">{{ __('Drag file here') }}</span>
                            <span x-show="isDropTarget">{{ __('Drop file to upload') }}</span>
                    </span>
                    <span x-show="!isValid || !hasDragObject" x-text="ruleHelpText"></span>
                </div>
            </div>
        @endif

    </button>
</div>
