    </div> <!-- End of .main-content -->

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Global Script Initialization -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 globally if class exists
            if ($('.select2').length > 0) {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Select Option'
                });
            }
        });
    </script>
</body>
</html>
