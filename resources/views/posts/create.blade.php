<x-app-layout>
    <x-slot name="header">
        <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4">
                <form action={{ route('posts.store')}} method=POST>
                    @csrf
                    <input type="text" name="title">
                    <input type="hidden" name="build_log_id" value="{{ app('request')->input('log_id') }}">
                    <select multiple="multiple" name="tags[]" id="tags">
                        @foreach($tags as $tag)
                            <option value="{{$tag->name}}">{{$tag->name}}</option>
                        @endforeach
                        </select>
                    <textarea id="body" name="post"></textarea>
                    <button type="submit" class="btn btn-success"> Save </button>


                
            </div>

            <hr>

        </div>
    </div>
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
    .create( document.querySelector( '#body' ), {
        extraPlugins: [ MyCustomUploadAdapterPlugin ],
    } )
    .catch( error => {
        console.error( error );
    } );
    </script>
</x-app-layout>