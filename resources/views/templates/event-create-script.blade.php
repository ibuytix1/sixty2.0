<script type="text/javascript">
    $(document).ready(function () {
        $('.disable-rec-eve').click(function () {
            $("#recuring_event").trigger("click");
        });

        $("#recuring_event").click(function () {
            if ($(this).is(":checked")) {
                $(".rucuring").show(500);
            } else {
                $(".rucuring").hide(500);
            }
        });
    });
</script>