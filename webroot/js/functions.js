    /* コードの開始 */
    function addItemToCart(e) {
        let cartItem = document.getElementById('cart-item');
        console.log('addItemToCart', cartItem)
    }

    function changePaymentType(e) {
        if(e.value == 2) {
            document.querySelector('.banking-qr-code').classList.remove('d-none');
            document.querySelector('.cash-payment').classList.add('d-none');
        } else {
            document.querySelector('.banking-qr-code').classList.add('d-none');
            document.querySelector('.cash-payment').classList.remove('d-none');
        }
        console.log('AAAA',e.value);
    }




    /* コードの終了 */
