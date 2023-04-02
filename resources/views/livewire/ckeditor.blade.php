
        <div class="bg-white rounded-lg p-5">

            <div class="flex flex-col space-y-10">
                <div wire:ignore>
                    <textarea wire:model="message"
                              class="min-h-fit h-128 "
                              name="message"
                              id="message"></textarea>
                </div>

                <div>
                    <span class="text-lg">You typed:</span>
                    <div class="w-full min-h-fit h-48 border border-gray-200">{{ $message }}</div>
                </div>
            </div>


        </div>




@push('scripts')


    <script>

class MyUploadAdapter {
    constructor( loader ) {
        this.loader = loader;
    }
 
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }
 
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }
 
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
 
        xhr.open( 'POST', "{{route('upload', ['_token' => csrf_token() ])}}", true );
        xhr.responseType = 'json';
    }
 
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;
 
        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;
 
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }
 
            resolve( response );
        } );
 
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }
 
    _sendRequest( file ) {
        const data = new FormData();
 
        data.append( 'upload', file );
 
        this.xhr.send( data );
    }
}
 
function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        return new MyUploadAdapter( loader );
    };
}

ClassicEditor
    .create( document.querySelector( '#message' ), {
        extraPlugins: [ MyCustomUploadAdapterPlugin ],
    } )
    .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('message', editor.getData());
                })
            })
    .catch( error => {
        console.error( error );
    } );

    </script>



@endpush
