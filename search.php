<input type="text" onkeyup="search()" id="mykeyword">
<div id="result">




</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    function search() {
        $("#result").html('');
        var keyword = $("#mykeyword").val();

        $.post('ajax.php', {
            keyword: keyword
        }, function(data) {
            $("#result").html(data);
        });


    }
</script>