(function(){
    /* コードの開始 */

    document.addEventListener('DOMContentLoaded', function() {
        customizeInputFileItem();

        let btnAction = document.getElementById('add-image-button')
        if(btnAction) btnAction.addEventListener('click', addInputFile);

        // btnAction = document.getElementById('save-product-button');
        // if(btnAction) btnAction.addEventListener('click', saveProduct);

        btnAction = document.getElementById('js-validate-form');
        if(btnAction) btnAction.addEventListener('submit', submitValidateForm)

        let cards = document.querySelectorAll('.card');
        if(cards) {
            cards.forEach((card, k) => {
                card.addEventListener('click', cardRedirectUrl)
            });
        }
    }, false);


    async function submitValidateForm(e) {
        e.preventDefault();
        console.log('submitValidateForm', e);
        // let formData = new FormData();
        let formData = new FormData(e.target);
        // postFetch(e.target.action, formData);
        // return;
        let imgList = e.target.querySelectorAll('input[type="file"]');
        let save_images = [];
        if(imgList) {
            imgList.forEach(async (v, k) => {
                let file = v.files[0];
                if(file) {
                    let image = new Image();
                    image.src = URL.createObjectURL(file);
                    const base64 = resizeImgToBase64(image);
                    console.log('submitValidateForm base64', base64);
                    const blob = base64ImgToBlob(base64);
                    const newFile = new File([blob], file.name,{ type: "image/png" })
                    formData.append('save_images[]', newFile);
                }
        //

                // let response = await fetch(base64)
                // .then(res => res.blob())
                // .then(blob => {
                //     const newFile = new File([blob], file.name,{ type: "image/png" })
                //     // formData.append('save_images[]', newFile);
                //     // let fileInput = document.createElement('input');
                //     // fileInput.type = 'file';
                //     // fileInput.name = 'save_image[]';
                //     // fileInput.value = JSON.stringify(newFile);
                //     // v.closest('.img-group').append(fileInput);
                //     console.log('submitValidateForm file', file);
                //     return newFile;
                // });
                // console.log('submitValidateForm response', response);
                // formData.append('save_images[]', newFile);
        //         // const reader = new FileReader();
        //         // reader.onload = function(event) {


        //         // }
        //         // reader.readAsDataURL(file);
        //         console.log('submitValidateForm file', v.files)
            });
        }
        for(const fd of formData.entries()) {
            console.log(`key:${fd[0]}-val:${fd[1]}`)
        }
        formData.delete('image_products[]');
        // sendPostForm(e.target.action, formData);
        // console.log('submitValidateForm save_images', save_images)
        let callback = (data) => {
            let errors = data.errors;
            if(document.querySelector('.message.error')) document.querySelector('.message.error').remove();
            if(document.querySelector('.message.success')) document.querySelector('.message.success').remove();
            if(Object.keys(errors).length) {
                for(const error of Object.entries(errors)) {
                    for(const err_mess of Object.entries(error[1])) {
                        let errorElm = document.createElement('div');
                        errorElm.classList = 'message error';
                        errorElm.onclick = this.classList.add('hidden');
                        errorElm.innerText = err_mess[1];
                        document.querySelector('.container .row').before(errorElm);
                        window.scrollTo(0,0);
                        return;
                    }

                }
            } else {
                let errorElm = document.createElement('div');
                errorElm.classList = 'message success';
                errorElm.onclick = this.classList.add('hidden');
                errorElm.innerText = 'The product has been saved.';
                document.querySelector('.container .row').before(errorElm);
                window.scrollTo(0,0);
            }

        };
        postFetch(e.target.action, formData, callback);
    }

    async function sendPostForm(url, formData) {
        postFetch(url, formData);
        // for(const fd of formData.entries()) {

        //     console.log(`${fd[0]}:${fd[1]}`)
        // }
    }

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
        let showImg = e.target.closest('.img-group').querySelectorAll('.show-image .image');
        let img = document.createElement('img');
        let file = e.target.files[0];
        img.src = URL.createObjectURL(file);
        showImg[0].append(img);
        e.target.closest('.img-group').querySelectorAll('.show-image .delete-image-button')[0].classList.remove('d-none');


        // const maxwidth = 200;

//   const file = this.files[0];
        // if (!file.type.match(/^image\/(png|jpeg|gif|jpg)$/)) return;
        // const image = new Image();
        // const reader = new FileReader();
        // reader.onload = function(evt) {
        //     image.onload = function() {
        //         // const width = maxwidth;
        //         // const height = image.height * (maxwidth / image.width);
        //         // const canvas = document.createElement("canvas");
        //         // canvas.setAttribute("width",width);
        //         // canvas.setAttribute("height",height);
        //         // const ctx = canvas.getContext('2d');
        //         // ctx.drawImage(image,0,0,width,height);

        //         const base64 = resizeImgToBase64(image);
        //         console.log('base64', base64);
        //         // var bin = atob(base64.replace(/^.*,/, ''));
        //         // var buffer = new Uint8Array(bin.length);
        //         // for (var i = 0; i < bin.length; i++) {
        //         //     buffer[i] = bin.charCodeAt(i);
        //         // }
        //         // // Blobを作成
        //         // try{
        //         //     var blob = new Blob([buffer.buffer], {
        //         //         type: 'image/png',
        //         //     });
        //         //     blob.name = file.name
        //         //     blob.size = file.size * (maxwidth / image.width)
        //         //     let saveImg = document.createElement('input');
        //         //     saveImg.type = 'file';
        //         //     saveImg.files[0] = blob;
        //         //     saveImg.name = 'save_images[]'
        //         //     e.target.closest('.img-group').append(saveImg);
        //         // }catch (e){
        //         //     return false;
        //         // }
        //         // console.log('base64', blob);



        //         let img = document.createElement('img');
        //         img.src = base64;
        //         // $("#base64").val(base64);
        //         showImg[0].append(img);

        //     }
        //     image.src = evt.target.result;
        // }
        // reader.readAsDataURL(file);


        // console.log('filechange', showImg)
    }

    function resizeImgToBase64(image) {
        const maxwidth = 200;
        const width = maxwidth;
        const height = image.height * (maxwidth / image.width);
        const canvas = document.createElement("canvas");
        canvas.setAttribute("width",width);
        canvas.setAttribute("height",height);
        const ctx = canvas.getContext('2d');
        ctx.drawImage(image,0,0,width,height);

        const base64 = canvas.toDataURL("image/png");
        return base64;
    }

    function base64ImgToBlob(base64) {
        var base64Data = base64.split(',')[1], // Data URLからBase64のデータ部分のみを取得
		data = window.atob(base64Data), // base64形式の文字列をデコード
		buff = new ArrayBuffer(data.length),
		arr = new Uint8Array(buff),
		blob, i, dataLen;

        // blobの生成
        for( i = 0, dataLen = data.length; i < dataLen; i++){
            arr[i] = data.charCodeAt(i);
        }
        blob = new Blob([arr], {type: 'image/png'});
        return blob;
    }

    /**
     * 画像選択の項目を追記する
     *
     * @param HtmlElement e
     */
    function addInputFile(e) {
        let imgGroup = document.querySelectorAll('.input.file .img-group');
        imgGroup = imgGroup[0].cloneNode(true);
        let input = imgGroup.querySelectorAll('input[type="file"]')[0]
        input.addEventListener('change', inputFileChange);
        input.value = '';
        let img = imgGroup.querySelectorAll('.show-image .image img');
        if(img && img.length) img[0].remove();
        imgGroup.querySelectorAll('.show-image .delete-image-button')[0].classList.add('d-none');
        document.querySelectorAll('.input.file')[0].append(imgGroup);
        console.log(imgGroup)
    }

    /**
     * カードを押下時に画面遷移を行う
     *
     * @param HtmlElement e
     */
    function cardRedirectUrl(e) {
        let parentForm = e.target.closest('form').submit();
        console.log('cardRedirectUrl', parentForm);
    }

    function saveProduct(e) {
        let form = e.target.closest('form');
        let formData = new FormData(form);

        console.log('formData', formData.entries);
        fetchPost(form.action, formData);
        //
        // validateForm(form);
    }

    function fetchPost(url, data) {
        let options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // 'Content-Type': 'application/multipart/form-data',
            },
            body: JSON.stringify(Object.fromEntries(data)),
        }
        fetch(url, options)
        .then((data) => {
            console.log('fetch data', data)
        })
        .then((response) => {
            console.log('fetch response', response)
        })
        .catch((error) => {
            console.log('fetch error', error)
        })
    }

    function validateForm(form) {
        // validate required input
        console.log('form', form)
        let error = false;
        let input = form.querySelectorAll('.input.text, .input.textarea, input.select');
        if(input) {
            input.forEach((v, k) => {
                let isRequired = v.classList.contains('required');
                if(isRequired) {
                    if(v.value == '' || v.value == null || v.value == undefined) form.submit();return false;
                }
                console.log('v class', v.classList.contains('required'))
                // if(v.target.classList.cont)
            })
        }
    }

    /* コードの終了 */
})();
