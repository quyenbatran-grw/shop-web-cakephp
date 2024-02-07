(function(){
    /* コードの開始 */

    document.addEventListener('DOMContentLoaded', function() {
        customizeInputFileItem();
        updateCartQuantity();

        // 画像追加ボタンを押下時
        let btnAction = document.getElementById('add-image-button')
        if(btnAction) btnAction.addEventListener('click', addInputFile);

        // btnAction = document.getElementById('save-product-button');
        // if(btnAction) btnAction.addEventListener('click', saveProduct);

        // バリデーション要求のフォームを送信する時
        btnAction = document.getElementById('js-validate-form');
        if(btnAction) btnAction.addEventListener('submit', submitValidateForm);

        //
        document.querySelectorAll('button.delete-image-button').forEach((elm) => {
            elm.addEventListener('click', removeUploadedImg)
        });

        // 配達日時変更
        btnAction = document.querySelector('input[name="delivery_date"]');
        if(btnAction) btnAction.addEventListener('change', changeDeliveryDate);

        btnAction = document.querySelector('select[name="delivery_hour_start"]');
        if(btnAction) btnAction.addEventListener('change', changeDeliveryDate);

        btnAction = document.querySelector('select[name="delivery_hour_end"]');
        if(btnAction) btnAction.addEventListener('change', changeDeliveryDate);

        // 緊急配達依頼
        btnAction = document.querySelector('input[name="immediate"]');
        if(btnAction) btnAction.addEventListener('change', changeImmediateFlg);

        // キャンセルボタン押下で確認モーダル表示


        let cards = document.querySelectorAll('.card');
        if(cards) {
            cards.forEach((card, k) => {
                card.addEventListener('click', cardRedirectUrl)
            });
        }

    }, false);


    // function getImageList(files) {
    //     let images_list = [];
    //     files.forEach(async (v, k) => {
    //         console.log('file', v.files[0])
    //         let res = reset(v.files[0]);
    //         images_list.push(res);
    //     });
    //     return images_list;
    // }

    // function reset(file) {
    //     let reader = new FileReader();
    //     reader.readAsDataURL(file);
    //     reader.onload = async () => {
    //         const imgData = reader.result;
    //         let image = new Image();
    //         image.src = imgData;

    //         const canvas = document.createElement('canvas');
    //         canvas.width = 200;
    //         canvas.height = 200;
    //         const ctx = canvas.getContext('2d');
    //         ctx.drawImage(image, 0, 0, 200, 200);
    //         const resizedImgData = canvas.toDataURL('image/png')
    //         console.log('resizedImgData', resizedImgData)
    //         images_list.push(resizedImgData);
    //     };
    // }

    /**
     * バリデーション必要なフォームを送信する
     *
     * @param HtmlElement e
     */
    async function submitValidateForm(e) {
        e.preventDefault();
        let formData = new FormData(e.target);
        let files = e.target.querySelectorAll('.show-image .image img');
        let save_images = {};
        const createFormDataPromise = new Promise((resolve, reject) => {
            if(files) {
                files.forEach((v, k) => {
                    const canvas = document.createElement('canvas');
                    canvas.width = 200;
                    canvas.height = 200;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(v, 0, 0, 200, 200);
                    const resizedImgData = canvas.toDataURL('image/png');
                    console.log('resizedImgData', resizedImgData);
                    const blob = base64ImgToBlob(resizedImgData, 'image/png');
                    let file = v.closest('.img-group').querySelector('input[type="file"]');
                    console.log('file', file);
                    if(file) {
                        file = file.files[0];
                        console.log('file', file)
                        const newFile = new File([blob], file.name, { type: 'image/png' });
                        formData.append('save_images[]', newFile);
                    }
                });
                resolve(true);
            }
        });
        createFormDataPromise.then((data) => {
            formData.delete('image_products[]');
            let callback = (data) => {
                console.log('data', data)
                let errors = data.errors;
                if(document.querySelector('.message.error')) document.querySelector('.message.error').remove();
                if(document.querySelector('.message.success')) document.querySelector('.message.success').remove();
                if(Object.keys(errors).length) {
                    for(const error of Object.entries(errors)) {
                        let errorContent = Object.entries(error[1]);
                        let textContent = errorContent[0] && errorContent[0][1] ? errorContent[0][1] : '';
                        if(textContent != '') {
                            console.log('error', errorContent[0][1]);
                            let errorElm = document.createElement('div');
                            errorElm.classList = 'fs-6 text-danger';
                            errorElm.textContent = textContent;
                            document.querySelector('[name="'+error[0]+'"]').parentElement.append(errorElm);
                        }
                    }
                } else {
                    if(data.redirect) {
                        location.href = data.redirect;
                    }
                    let errorElm = document.createElement('div');
                    errorElm.classList = 'message success';
                    errorElm.onclick = this.classList.add('hidden');
                    errorElm.innerText = 'The product has been saved.';
                    document.querySelector('.container .row').before(errorElm);
                    window.scrollTo(0,0);
                }

            };
            console.log('action', e.target.action);
            console.log('formdata', formData);
            postFetch(e.target.action, formData, callback);
            console.log('save_images', Object.keys(save_images))
        });
    }

    function updateCartQuantity() {
        let quantityElements = document.querySelectorAll('.cart-list select.change-quantity');
        if(quantityElements) {
            quantityElements.forEach((v, k) => {
                v.addEventListener('change', (e) => {
                    e.target.closest('form').submit();
                    console.log('updateCartQuantity', e)
                })
            })
        }

    }


    function changeStatusConfirm() {
        console.log('change status');
    }
    /**
     * POSTで送信する
     *
     * @param {string} url 送信先のURL
     * @param {FormData} data 送信データ
     * @param {Function} callback コールバックファンクション
     * @param {Headers|null} headers 送信ヘッダー
     */
    function postFetch(url, data, callback, headers = null) {
        let options = {
            method: 'POST',
            body: data,
            mode: 'no-cors'
        };
        if(headers !== null) options.headers = headers;
        fetch(url, options)
        .then((response) => {
            return response.json();
        })
        .then(callback)
        .catch((error) => {
            console.log('fetch error', error)
        })
    }


    /**
     * 画像アップロードの表示は成形
     */
    function customizeInputFileItem() {
      document.querySelectorAll('input[type="file"]').forEach((file, key) => {
        let div = document.createElement('div');
        div.classList = 'd-grid gap-2 img-group mb-2';
        let newFile = document.createElement('input');
        newFile.name = file.name;
        newFile.type = file.type;
        newFile.addEventListener('change', inputFileChange);
        div.append(newFile);
        //
        let showImgGroup = document.createElement('div');
        showImgGroup.className = 'show-image w-75 d-flex';
        let showImg = document.createElement('div');
        showImg.className = 'image';
        showImgGroup.append(showImg);
        div.append(showImgGroup);
        //
        let deleteBtn = document.createElement('button');
        deleteBtn.innerText = 'Delete';
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-danger mx-2 d-none delete-image-button';
        showImgGroup.append(deleteBtn);
        //
        file.closest('.file').append(div);
        file.remove();
      });
    }

    /**
     * 画像選択した瞬間に呼び出すメソッド
     *
     * @param HtmlElement e
     */
    function inputFileChange(e) {
        e.preventDefault();
        let showImg = e.target.closest('.img-group').querySelector('.show-image .image');
        let file = e.target.files[0];

        // console.log('showImg', showImg)
        if(showImg.querySelector('img')) {
            showImg.querySelector('img').src = URL.createObjectURL(file);
        } else {
            let img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            showImg.append(img);
        }

        e.target.closest('.img-group').querySelector('.show-image .delete-image-button').classList.remove('d-none');
    }

    function resizeImgToBase64(image) {
        const maxwidth = image.width;
        const width = maxwidth;
        const height = image.height * (maxwidth / image.width);
        const canvas = document.createElement("canvas");
        canvas.setAttribute("width",width);
        canvas.setAttribute("height",height);
        const ctx = canvas.getContext('2d');
        ctx.drawImage(image,0,0,width,height);

        const base64 = canvas.toDataURL(image.type);
        return base64;
    }

    function base64ImgToBlob(base64, type) {
        var base64Data = base64.split(',')[1], // Data URLからBase64のデータ部分のみを取得
		data = window.atob(base64Data), // base64形式の文字列をデコード
		buff = new ArrayBuffer(data.length),
		arr = new Uint8Array(buff),
		blob, i, dataLen;

        // blobの生成
        for( i = 0, dataLen = data.length; i < dataLen; i++){
            arr[i] = data.charCodeAt(i);
        }
        blob = new Blob([arr], {type: type});
        return blob;
    }

    /**
     * 画像選択の項目を追記する
     *
     * @param HtmlElement e
     */
    function addInputFile(e) {
        // image group element
        let imgGroup = document.createElement('div');
        imgGroup.classList = 'col img-group col-mb-2';
        // image upload element
        let inputFile = document.createElement('input');
        inputFile.classList = 'visually-hidden';
        inputFile.type = 'file';
        inputFile.name = 'image_products[]';
        inputFile.addEventListener('change', inputFileChange);
        imgGroup.append(inputFile);
        // display uploaded image element
        let showImg = document.createElement('div');
        showImg.classList = 'show-image w-75 d-flex';
        let imgDiv = document.createElement('div');
        imgDiv.classList = 'image';
        let deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn-danger d-none delete-image-button';
        // deleteBtn.addEventListener('click', removeUploadedImg);
        showImg.append(imgDiv);
        showImg.append(deleteBtn);
        imgGroup.append(showImg);

        let imageFileList = document.querySelector('.image_list');
        imageFileList.append(imgGroup);
        inputFile.click();

        // let inputf = document.querySelectorAll('.input.file .img-group');
        // imgGroup = imgGroup[0].cloneNode(true);
        // let input = imgGroup.querySelectorAll('input[type="file"]')[0]
        // input.addEventListener('change', inputFileChange);
        // input.value = '';
        // let img = imgGroup.querySelectorAll('.show-image .image img');
        // if(img && img.length) img[0].remove();
        // imgGroup.querySelectorAll('.show-image .delete-image-button')[0].classList.add('d-none');
        // document.querySelectorAll('.input.file')[0].append(imgGroup);
        // console.log(imgGroup)
    }

    /**
     * アップロードした未登録の画像を削除
     * @param {*} e
     */
    function removeUploadedImg(e) {
        let parent = e.target.parentElement;
        if(parent.getAttribute('delete-id') != undefined && parent.getAttribute('delete-id') != '') {
            var deleted_img = document.querySelector('input[name="deleted_img"]').value;
            deleted_img = (deleted_img != '' ? deleted_img + ',' : '') + parent.getAttribute('delete-id');
            document.querySelector('input[name="deleted_img"]').value = deleted_img
            e.target.closest('.img-group').remove();
        } else {
            e.target.closest('.img-group').remove();
        }
    }

    /**
     * カードを押下時に画面遷移を行う
     *
     * @param HtmlElement e
     */
    function cardRedirectUrl(e) {
        if(e.target.closest('form')) e.target.closest('form').submit();
    }

    /**
     * 配送日時変更
     * @param {*} e
     */
    function changeDeliveryDate(e) {
        console.log(e.target.value)
        if(e.target.name == 'delivery_date') {
            // 日付変更
            let today = moment().format('YYYY-MM-DD');
            if(e.target.value < today) e.target.value = today
            else {
                let start_time = moment().add(1, 'H').format('HH');
                let end_time = moment().add(2, 'H').format('HH');
                document.querySelector('select[name="delivery_hour_start"]').value = start_time;
                document.querySelector('select[name="delivery_hour_end"]').value = end_time;
                document.querySelectorAll('select[name="delivery_hour_start"] option').forEach((elm) => {
                    elm.disabled = false;
                    if(e.target.value == today && elm.value < start_time) elm.disabled = true;
                });
                document.querySelectorAll('select[name="delivery_hour_end"] option').forEach((elm) => {
                    elm.disabled = false;
                    if(e.target.value == today && elm.value < start_time) elm.disabled = true;
                });
            }
        } else if(e.target.name == 'delivery_hour_start' || e.target.name == 'delivery_hour_end') {
            let start_time = document.querySelector('select[name="delivery_hour_start"]').value;
            let end_time = document.querySelector('select[name="delivery_hour_end"]').value;
            console.log('start_time', start_time)
            console.log('end_time', end_time)
            if(start_time > end_time) document.querySelector('select[name="delivery_hour_end"]').classList.add('border', 'border-danger');
            else document.querySelector('select[name="delivery_hour_end"]').classList.remove('border', 'border-danger');
        }
        // var start_hour, start_min;
        // let current_time = moment().format('YYYY-MM-DD HH:mm');

        // let delivery_type = document.querySelector('input[name="delivery_type"]:checked').value;
        // if(delivery_type == 1) {
        //     start_hour = moment().add(60, 'm').format('HH');
        //     start_min = moment().add(60, 'm').format('mm');
        // } else {
        //     start_hour = moment().add(30, 'm').format('HH');
        //     start_min = moment().add(30, 'm').format('mm');
        // }
        // document.querySelector('select[name="delivery_hour_start"]').value = start_hour;
        // document.querySelector('select[name="delivery_min_start"]').value = start_min;
        // document.querySelector('select[name="delivery_hour_end"]').value = start_hour;
        // document.querySelector('select[name="delivery_min_end"]').value = start_min;
        // let delivery_date = e.target.value;
        // current_time.setMinutes(current_time.getMinutes + 30);
        // var check_time = current_time.getFullYear() + '-' + ('0' + (current_time.getMonth() + 1)).slice(-2) + '-' + ('0' + current_time.getDate()).slice(-2);
        // check_time += current_time.getHours() + current_time.getMinutes();

        // console.log('delivery_type', delivery_type)
        // console.log('start_time', start_hour)
        // console.log('start_min', start_min)
    }

    /**
     * 緊急配送依頼の有無
     * @param {*} e
     */
    function changeImmediateFlg(e) {
        if(e.target.checked) {
            document.querySelector('input[name="delivery_date"]').disabled = true;
            document.querySelector('select[name="delivery_hour_start"]').disabled = true;
            document.querySelector('select[name="delivery_hour_end"]').disabled = true;
        } else {
            document.querySelector('input[name="delivery_date"]').disabled = false;
            document.querySelector('select[name="delivery_hour_start"]').disabled = false;
            document.querySelector('select[name="delivery_hour_end"]').disabled = false;
        }
        console.log(e.target.checked)
    }

    /* コードの終了 */
})();
