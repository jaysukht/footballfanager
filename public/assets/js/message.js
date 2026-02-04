 function SuccessMsg(msg, txtColor='#fff', duration=3000, className="commonPopupMsg"){
    Toastify({
        text: msg,
        className: className,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        style:{
            //background: "linear-gradient(to right, '"+txtColor+"', '"+txtColor+"')",
            color: txtColor
        },
        callback: function(){
            $('body').removeClass('FlashMessage-Box');
        }
    }).showToast();
    $('body').addClass('FlashMessage-Box');
 }

 function ErrorMsg(msg, txtColor='#fdcbcb', duration=3000, className="commonPopupMsg"){
    if(txtColor == ''){
        txtColor = '#fdcbcb';
    }
    Toastify({
        text: msg,
        className: className,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        style:{
            //background: "linear-gradient(to right, '"+txtColor+"', '"+txtColor+"')",
            color: txtColor
        },
        callback: function(){
            $('body').removeClass('FlashMessage-Box');
        }
    }).showToast();
    $('body').addClass('FlashMessage-Box');
 }

 function CustomErrorMsg(msg){
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#fdcbcb",
        callback: function(){
            $('body').removeClass('FlashMessage-Box');
        }
    }).showToast();
    $('body').addClass('FlashMessage-Box');
 }