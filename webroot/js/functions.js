    /* コードの開始 */
    function addItemToCart(e) {
        let cartItem = document.getElementById('cart-item');
        console.log('addItemToCart', cartItem)
    }

    /**
     * 支払方法の選択
     * @param {*} e
     */
    function changePaymentType(e) {
        if(e.value == 1) {
            document.querySelector('.banking-qr-code').classList.remove('d-none');
            document.querySelector('.cash-payment').classList.add('d-none');
        } else {
            document.querySelector('.banking-qr-code').classList.add('d-none');
            document.querySelector('.cash-payment').classList.remove('d-none');
        }
        console.log('AAAA',e.value);
    }

    /**
     * ポイント支払選択
     * @param {*} e
     */
    function changePaymentPoint(e) {
        if(e.type == 'radio') {
            if(e.value == 1) {
                let all_point = parseInt(document.querySelector('input[name="payment_point"]').getAttribute('max'));
                document.querySelector('input[name="payment_point"]').value = all_point;
                document.querySelector('.pay-with-point .point').textContent = 0 - all_point;
                var totalAmount = document.querySelector('.amount').textContent;
                totalAmount = totalAmount.replace(',', '');
                if(totalAmount != '') {
                    totalAmount = parseInt(totalAmount) - all_point;
                } else {
                    totalAmount = 0;
                }
                totalAmount = new Intl.NumberFormat().format(totalAmount);
                document.querySelector('.total_amount').textContent = totalAmount;
            }
        } else if(e.type == 'number') {
            var point = document.querySelector('input[name="payment_point"]').value;
            let max_point = parseInt(document.querySelector('input[name="payment_point"]').getAttribute('max'));
            if(point == '' || point < 0) point = 0;
            else if(point > max_point) point = max_point;
            document.querySelector('input[name="payment_point"]').value = point;
            var totalAmount = document.querySelector('.amount').textContent;
            totalAmount = totalAmount.replace(',', '');
            if(totalAmount != '') {
                totalAmount = parseInt(totalAmount) - point;
            } else {
                totalAmount = 0;
            }
            totalAmount = new Intl.NumberFormat().format(totalAmount);
            document.querySelector('.total_amount').textContent = totalAmount;
            document.querySelector('.pay-with-point .point').textContent = 0 - point;
        }
    }




    /* コードの終了 */
