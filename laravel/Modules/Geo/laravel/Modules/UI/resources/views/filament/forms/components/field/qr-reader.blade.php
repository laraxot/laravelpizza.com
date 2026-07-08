<?php

declare(strict_types=1);

?>
<x-filament-forms::field-wrapper :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div x-data="{ state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }} }"
        class="h-full w-full flex flex-col py-4 md:py-6 lg:py-8 m-0 gap-8 overflow-auto scroll-smooth">
        <div id="qr-reader"></div>

        <button
            class="text-center w-fit flex items-center justify-center border bg-blue-400 p-2 uppercase text-white font-normal rounded-xl min-w-[150px]"
            onclick="startScan()">Scansiona</button>

        <div class="flex flex-col gap-4 w-full">
            <h2 class="font-bold text-slate-500 text-xl">Cerca</h2>
            <input id="card-filter" type="text" placeholder="Cerca"
                class="w-full px-4 py-2 border border-black rounded-xl text-sm text-slate-500 min-h-[50px] bg-white active:border-orange-500 focus:border-orange-500"
                x-model="state">
        </div>
    </div>
</x-filament-forms::field-wrapper>
@push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        var lastResult, countResults, html5QrCode, config = undefined;

        document.addEventListener('DOMContentLoaded', () => {
            lastResult,
            countResults = 0;

            html5QrCode = new Html5Qrcode("qr-reader");

            config = {
                fps: 10,
                qrbox: (viewfinderWidth, viewfinderHeight) => {
                    let minEdgePercentage = 0.7;
                    let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
                    let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
                    return {
                        width: qrboxSize,
                        height: qrboxSize
                    };
                },
                rememberLastUsedCamera: true,
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
            };
        })

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                console.log(`Scan result ${decodedText}`, decodedResult);

                document.getElementById('card-filter').value = decodedText
            }

            html5QrCode.stop().then((ignore) => {
                console.error("stop", ignore)
                document.getElementById('qr-reader').style.display = 'none'
            }).catch((err) => {
                console.error(err)
            });
        };

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        const startScan = () => {
            if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
                document.getElementById('qr-reader').style.display = 'block'

                Html5Qrcode.getCameras()
                    .then(devices => {
                        html5QrCode.start({
                            facingMode: "environment"
                        }, config, qrCodeSuccessCallback);

                        /*if (devices && devices.length) {
                            var cameraId = devices[0].id;

                            html5QrCode
                                .start(
                                    cameraId, config,
                                    (decodedText, decodedResult) => qrCodeSuccessCallback(decodedText,
                                        decodedResult),
                                    (errorMessage) => {
                                        console.warn(`Code scan error = ${errorMessage}`);
                                    })
                                .catch((err) => {
                                    console.error(err)
                                });
                        } else {
                            html5QrCode.start({
                                facingMode: "environment"
                            }, config, qrCodeSuccessCallback);
                        }

                        html5QrCode.stop().then((ignore) => {
                            console.error("stop", ignore)
                        }).catch((err) => {
                            console.error(err)
                        });*/
                    })
                    .catch(err => {
                        console.error(err)
                    })
            }
        }
    </script>
@endpush
