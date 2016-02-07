<nav class="navbar navbar-default navbar-fixed-bottom">
    <div id="copyright" style="text-align: center;">
        Тестовое задание #297034 &copy; 2016 <a href="mailto:gergilenko@gmail.com">Gergilenko Yuriy</a>
    </div>
</nav>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $("a[id]").bind('click', function() {
            return window.confirm('Вы уверены, что хотите удалить?');
        });
        $('#saveday').click(function(){
            return valiDate();
        });
        function valiDate(){
            var pattern =  <?= DATE_PATTERN ?>;
            var date = $('input[name="date"]').val();
            $('.alert').remove();
            if(date != '' && !pattern.test(date)){
                $('.row').before('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Неверный формат даты. Используйте ГГГГ-ММ-ДД.</div>');
                return false;
            }
            return true;
        }
    });
</script>
</body>
</html>