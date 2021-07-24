$(document).ready(function(){

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    
    $(".next").click(function(e){
        if($(e.target).hasClass('set1')){
            // if($('#harga')[0].value == ''){
            //     alert('Harga (per kg) harus diisi')
            //     return false
            // }
            let material = $('.accordion-item')
            for (let i = 0; i < material.length; i++) {
                let header = $(material[i]).find('.no-material')[0].innerHTML
                if($(material[i]).find('.berat')[0].value == '' || $(material[i]).find('.berat')[0].value == 0){
                    alert(`Input berat(kg) di material ${header} tidak boleh kosong`)
                    return false
                }
                if($(material[i]).find('.harga')[0].value == ''){
                    alert(`Input harga/kg di material ${header} tidak boleh kosong`)
                    return false
                }
                if($(material[i]).find('.kategori')[0].value == 'Pilih kategori'){
                    alert(`Anda belum memilih kategori di material ${header}`)
                    return false
                }
                if($(material[i]).find('.jenis')[0].value == 'Pilih jenis'){
                    alert(`Anda belum memilih jenis di material ${header}`)
                    return false
                }
                if($(material[i]).find('.barang:checked').length == 0){
                    alert(`Anda belum memilih barang di material ${header}`)
                    return false
                }
            }
        }
        if($(e.target).hasClass('set2')){
            if($("#mitra")[0].value == "Pilih mitra"){
                alert("Anda belum memilih mitra")
                return false
            }
        }
        let jumlahMaterial = $('.accordion-item').length
        $('#jumlahmaterial')[0].innerHTML = jumlahMaterial
    
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    
    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    
    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
    step: function(now) {
    // for making fielset appear animation
    opacity = 1 - now;
    
    current_fs.css({
    'display': 'none',
    'position': 'relative'
    });
    next_fs.css({'opacity': opacity});
    },
    duration: 600
    });
    });
    
    $(".previous").click(function(){
    
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    
    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
    //show the previous fieldset
    previous_fs.show();
    
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
    step: function(now) {
    // for making fielset appear animation
    opacity = 1 - now;
    
    current_fs.css({
    'display': 'none',
    'position': 'relative'
    });
    previous_fs.css({'opacity': opacity});
    },
    duration: 600
    });
    });
    
    $('.radio-group .radio').click(function(){
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
    });
    
    $(".submit").click(function(){
    return false;
    })

    
    
    });