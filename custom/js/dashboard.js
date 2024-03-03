$(document).ready(function() {
    $('#codeValidation').modal({ show: false})
    let scanner =  new Instascan.Scanner({ video: document.getElementById('preview')})
    let data = {}
    scanner.addListener('scan', function(c){
        console.log(c)
        data = {
            'data' : $('#attendance_type').val(),
            'qrData' : c 
        }

        if(data['data'] != ""){
            $('#codeValidation').modal('show');
        }else{
            alert('Please select attendance type.')
        }
        
    })

    $('#validate').on('click', function(e){
        e.preventDefault()

        data['validator'] = $('#password').val()
        // console.log(data)
        $.ajax({
            type: 'POST',
            url: 'php_action/postAttendance.php',
            data: data,
            success: function(response) {
                let json = JSON.parse(response)
    
                if(json.success == true){
                    scanner.stop()
                    $('#scannerContainer').attr('hidden', true)
                    alert('Attendance Successful')
                    $('#codeValidation').modal('hide');
                    speak(json.greeting, json.name, json.end_greet)
                }else{
                    alert(json.messages)
                }
                        
            },
            error: function(e) {
                alert('Failed to check attendance. Please try again.')
            }
        })
    })


    $('#openCamera').on('click', function(){
        $('#scannerContainer').attr('hidden', false)
        
        Instascan.Camera.getCameras().then(function(cameras){
            if(cameras.length > 0){
                scanner.start(cameras[0])
            }else{
                alert('Unable to find camera')
            }
        }).catch(function(e){
            console.error(e)
        })
    })

    const speak = (greeting, name, end = "") => {
        var msg = new SpeechSynthesisUtterance( greeting + ", " + name + ", " + end + ".");
        msg.rate = 0.85
        window.speechSynthesis.speak(msg);
    }
})