function modalNotify(text)
{
    $("#popup-notify").find(".modal-body").html(text);
    $('#popup-notify').modal('show');
}

function ValidationFormSelf(ele='')
{
    if(ele)
    {
        $("."+ele).find("input[type=submit]").removeAttr("disabled");
        var forms = document.getElementsByClassName(ele);
        var validation = Array.prototype.filter.call(forms,function(form){
            form.addEventListener('submit', function(event){
                if(form.checkValidity() === false)
                {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }
}

function loadPagingAjax(url='',eShow='')
{
    if($(eShow).length && url)
    {
        $.ajax({
            url: url,
            type: "GET",
            data: {
                eShow: eShow
            },
            success: function(result){
                $(eShow).html(result);
            }
        });
    }
}

function doEnter(event,obj)
{
    if(event.keyCode == 13 || event.which == 13) onSearch(obj);
}


function onSearch(obj) 
{           
    var keyword = $("#"+obj).val();
    
    if(keyword=='')
    {
        modalNotify(LANG['no_keywords']);
        return false;
    }
    else
    {
        location.href = "tim-kiem?keyword="+encodeURI(keyword);
        loadPage(document.location);            
    }
}

function doEnterFilter(event,obj)
{
    if(event.keyCode == 13 || event.which == 13) onFilter(obj);
}
function onFilter(obj) {
    var keyword = $("#"+obj).val(),
        id_khoihanh = $("#id_khoihanh").val(),
        id_noiden = $("#id_noiden").val(),
        id_list = $('input[name="id_list"]:checked').val(),
        id_songaydi = $("#id_songaydi").val();
    location.href = "filter?keyword="+encodeURI(keyword)+"&id_khoihanh="+id_khoihanh+"&id_noiden="+id_noiden+"&id_songaydi="+id_songaydi+"&id_list="+id_list;
    loadPage(document.location);          
}
function goToByScroll(id)
{
    var offsetMenu = 0;
    id = id.replace("#", "");
    if($(".menu").length) offsetMenu = $(".menu").height();
    $('html,body').animate({
        scrollTop: $("#" + id).offset().top - (offsetMenu * 2)
    }, 'slow');
}

function getTotalOrder($inputName='')
{
    var sotreem = $("input[name='treem']").val();
    var songuoilon = $("input[name='nguoilon']").val();
    var soembe = $("input[name='embe']").val();
    var id = $("input[name='idsp']").val();
    $.ajax({
        type: "POST",
        url: "ajax/get_total_order.php",
        dataType: 'json',
        data: {sotreem:sotreem,songuoilon:songuoilon,soembe:soembe,id:id},
        success: function(result){
            if(result)
            {
                $('.total-tour span').html(result.totalText);
            }
        }
    });
}

function update_cart(id=0,code='',quantity=1)
{
    if(id)
    {
        var ship = $(".price-ship").val();

        $.ajax({
            type: "POST",
            url: "ajax/ajax_cart.php",
            dataType: 'json',
            data: {cmd:'update-cart',id:id,code:code,quantity:quantity,ship:ship},
            success: function(result){
                if(result)
                {
                    $('.load-price-'+code).html(result.gia);
                    $('.load-price-new-'+code).html(result.giamoi);
                    $('.price-temp').val(result.temp);
                    $('.load-price-temp').html(result.tempText);
                    $('.price-total').val(result.total);
                    $('.load-price-total').html(result.totalText);
                }
            }
        });
    }
}

function load_district(id=0)
{
    $.ajax({
        type: 'post',
        url: 'ajax/ajax_district.php',
        data: {id_city:id},
        success: function(result){
            $(".select-district").html(result);
            $(".select-wards").html('<option value="">'+LANG['wards']+'</option>');
        }
    });
}

function load_wards(id=0)
{
    $.ajax({
        type: 'post',
        url: 'ajax/ajax_wards.php',
        data: {id_district:id},
        success: function(result){
            $(".select-wards").html(result);
        }
    });
}

function load_ship(id=0)
{
    if(SHIP_CART)
    {
        $.ajax({
            type: "POST",
            url: "ajax/ajax_cart.php",
            dataType: 'json',
            data: {cmd:'ship-cart',id:id},
            success: function(result){
                if(result)
                {
                    $('.load-price-ship').html(result.shipText);
                    $('.load-price-total').html(result.totalText);
                    $('.price-ship').val(result.ship);
                    $('.price-total').val(result.total);
                }   
            }
        }); 
    }
}