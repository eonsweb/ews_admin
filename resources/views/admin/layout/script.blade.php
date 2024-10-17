<!-- Popper JS -->
<script src=" {{ asset('admin/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

<!-- Bootstrap JS -->
<script src=" {{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Defaultmenu JS -->
<script src=" {{ asset('admin/assets/js/defaultmenu.min.js') }}"></script>

<!-- Node Waves JS-->
<script src=" {{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>

<!-- Sticky JS -->
<script src=" {{ asset('admin/assets/js/sticky.js') }}"></script>



<!-- Color Picker JS -->
<script src=" {{ asset('admin/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>


<!-- iziToast JS -->
<script src=" {{ asset('admin/assets/js/iziToast.min.js') }}"></script>


<!-- Custom-Switcher JS -->
<script src=" {{ asset('admin/assets/js/custom-switcher.min.js') }}"></script>

<!-- Simplebar JS -->
<script src=" {{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src=" {{ asset('admin/assets/js/simplebar.js') }}"></script>

<!-- Custom JS -->
<script src=" {{ asset('admin/assets/js/custom.js') }}"></script> 

 <!-- Prism JS -->
 <script src="{{ asset('admin/assets/libs/prismjs/prism.js')}}"></script>
 <script src="{{ asset('admin/assets/js/prism-custom.js')}}"></script>

 <!-- Filepond JS -->
 <script src="{{ asset('admin/assets/libs/filepond/filepond.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
 <script src="{{ asset('admin/assets/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js') }}"></script>

 <!-- Dropzone JS -->
 {{-- <script src="{{ asset('admin/assets/libs/dropzone/dropzone-min.js') }}"></script> --}}

 <!-- Fileupload JS -->
 {{-- <script src="{{ asset('admin/assets/js/fileupload.js') }}"></script> --}}

{{-- Other global scripts --}}
@stack('scripts')
<script>
    @if(Session::has('message'))
        let type = "{{ Session::get('alert-type','info') }}";
        let message = " {{ Session::get('message') }} ";
        let title = "";
        switch(type)
        {
            case 'info': 
                iziToast.info({
                    title:title,
                    message: message,
                    position: 'topRight',
                    timeout:1000,
                });
                break;

            case 'success': 
                iziToast.success({
                    title:title,
                    message: message,
                    position: 'topRight',
                    timeout:1000,
                });
                break;

            case 'error': 
                iziToast.error({
                    title:title,
                    message: message,
                    position: 'topRight',
                    timeout:1000,
                });
                break;

            case 'warning': 
                iziToast.warning({
                    title:title,
                    message: message,
                    position: 'topRight',
                    timeout:1000,
                });
                break;

        }
    @endif
</script>

</body>

</html>