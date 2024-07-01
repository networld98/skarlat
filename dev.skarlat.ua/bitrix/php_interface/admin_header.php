<?
CJSCore::Init(array("jquery"));
?>
<style>
    #affiliate.disabled {
        height: 25px !important;
        color: #ced2d5!important;
        cursor: default;
        padding: 8px 15px 0 !important;
        background: #f3f6f7!important;
    }
    #bx-admin-prefix p.description_prefix {
        margin-left: 20px;
    }
</style>
<script>
    $(document).ready(function () {
        $("input[name='UF_COUPON']").attr('readonly', true);
        let discountVal = $("input[name='UF_CLIENT_DISCONT']").val();
        let coupon = $("input[name='UF_COUPON']").val();
        let userId = '<?=$_GET['ID']?>';
        let partner = '<?=$_GET['partner']?>';
        if(partner === 'Y'){
            $('#tab_cont_cedit1').trigger('click');
        }
        $.ajax({
            type: "POST",
            url: '/ajax/generateCoupon.php',
            data: {"discountList":"Y","discountValue":discountVal,"coupon":coupon,"user":userId},
            success: function (data) {
                // Вывод текста результата отправки
                $('#table_UF_CLIENT_DISCONT').find('tr').html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: '/ajax/generatePartnerAdmin.php',
            data: {"user":userId},
            success: function (data) {
                // Вывод текста результата отправки
                $('#tr_cedit1_csection2').parent().append(data);
            }
        });
        $('#blacklist').click(function () {
            event.preventDefault();
            function getGet(name) {
                var s = window.location.search;
                s = s.match(new RegExp(name + '=([^&=]+)'));
                return s ? s[1] : false;
            }
            let id = getGet('&ID');
            let block = getGet('IBLOCK_ID');
            console.log(id);
            console.log(block);
            $.ajax({
                type: "POST",
                url: '/ajax/blacklist.php',
                data:{
                    item_id: id,
                    item_block: block,
                },
                success: function (data) {
                    $("#blacklist").html(data);
                }
            });
            return false;
        })
    })
</script>