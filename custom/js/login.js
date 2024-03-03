$(document).ready(function(){
    let registerBtn = $('#createUser')

    registerBtn.attr('disabled',true)
    $('#regConfPassword').on('keyup', function(){
        checkVal()
    })

    $('#modalClose').on('click', function(){
        $('#full_name').val('')
        $('#regUsername').val('')
        $('#regPassword').val('')
        $('#regConfPassword').val('')
    })

    const checkVal = () =>{
        if($('#regPassword').val() !== "" && $('#regConfPassword').val() !== "" && $('#regPassword').val() === $('#regConfPassword').val()){
            registerBtn.attr('disabled',false)
            $('#match').attr('hidden',false)
            $('#notMatch').attr('hidden',true)
            $('#qrBTN').attr('disabled', false)
        }else if($('#regPassword').val() !== "" && $('#regConfPassword').val() !== "" && $('#regPassword').val() !== $('#regConfPassword').val()){
            $('#match').attr('hidden',true)
            $('#notMatch').attr('hidden',false)
            $('#qrBTN').attr('disabled', true)
        }else{
            registerBtn.attr('disabled',true)
            $('#match').attr('hidden',true)
            $('#notMatch').attr('hidden',true)
            $('#qrBTN').attr('disabled', true)
        }
    }
    
    console.log('hey')

})