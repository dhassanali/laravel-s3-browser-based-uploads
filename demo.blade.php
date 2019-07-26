<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test</title>

        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    </head>
    <body>

        <input type="file" name="file" id="fileInput">

        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script>
            const pond = FilePond.create(document.querySelector('input[type="file"]'));

            pond.setOptions({
                server: {
                    process:(fieldName, file, metadata, load, error, progress, abort) => {
                        const formData = new FormData();

                        @foreach(S3BrowserBasedUploads::getFields() as $key => $value)
                            formData.append('{{ $key }}', '{{ $value }}');
                        @endforeach

                        formData.append('Content-Type', file.type);
                        formData.append(fieldName, file, file.name);

                        const request = new XMLHttpRequest();
                        request.open('POST', "{{ S3BrowserBasedUploads::getEndpointUrl() }}");

                        request.upload.onprogress = (e) => {
                            progress(e.lengthComputable, e.loaded, e.total);
                        };

                        request.onload = function() {
                            if (request.status >= 200 && request.status < 300) {
                                load(request.responseText);
                            }
                            else {
                                error('oh no');
                            }
                        };

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            }
                        };
                    }
                }
            });

        </script>
    </body>
</html>
