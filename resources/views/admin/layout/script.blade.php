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

<!-- Simplebar JS -->
<script src=" {{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src=" {{ asset('admin/assets/js/simplebar.js') }}"></script>

<!-- Color Picker JS -->
<script src=" {{ asset('admin/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>


<!-- iziToast JS -->
<script src=" {{ asset('admin/assets/js/iziToast.min.js') }}"></script>


<!-- Custom-Switcher JS -->
<script src=" {{ asset('admin/assets/js/custom-switcher.min.js') }}"></script>

<!-- Custom JS -->
<script src=" {{ asset('admin/assets/js/custom.js') }}"></script>


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