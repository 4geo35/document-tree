<div class="{{ $document || $documentError ? '' : 'hidden' }}">
    <x-tt::notifications.error prefix="signature-document-" />
    @if ($document)
        <div class="card">
            <div class="card-header border-b-0">
                <div class="space-y-indent-half">
                    @include("dt::admin.document-signatures.includes.list-title")
                    <x-tt::notifications.error prefix="signature-" />
                    <x-tt::notifications.success prefix="signature-" />
                </div>
            </div>
        </div>
    @endif
</div>
