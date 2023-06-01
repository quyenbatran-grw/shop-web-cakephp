(function(){
    /* コードの開始 */

    document.addEventListener('DOMContentLoaded', function() {
        customizeInputFileItem();

        // 画像追加ボタンを押下時
        let btnAction = document.getElementById('add-image-button')
        if(btnAction) btnAction.addEventListener('click', addInputFile);

        // btnAction = document.getElementById('save-product-button');
        // if(btnAction) btnAction.addEventListener('click', saveProduct);

        // バリデーション要求のフォームを送信する時
        btnAction = document.getElementById('js-validate-form');
        if(btnAction) btnAction.addEventListener('submit', submitValidateForm)

        let cards = document.querySelectorAll('.card');
        if(cards) {
            cards.forEach((card, k) => {
                card.addEventListener('click', cardRedirectUrl)
            });
        }
    }, false);

    function getImageList(files) {
        let images_list = [];
        files.forEach(async (v, k) => {
            console.log('file', v.files[0])
            let res = reset(v.files[0]);
            images_list.push(res);
        });
        return images_list;
    }

    function reset(file) {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = async () => {
            const imgData = reader.result;
            let image = new Image();
            image.src = imgData;

            const canvas = document.createElement('canvas');
            canvas.width = 200;
            canvas.height = 200;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(image, 0, 0, 200, 200);
            const resizedImgData = canvas.toDataURL('image/png')
            console.log('resizedImgData', resizedImgData)
            images_list.push(resizedImgData);
        };
    }

    async function submitValidateForm(e) {
        e.preventDefault();
        console.log('submitValidateForm', e);
        // let formData = new FormData();
        let formData = new FormData(e.target);
        // postFetch(e.target.action, formData);
        // return;
        // let files = e.target.querySelectorAll('input[type="file"]');
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
                    file = file.files[0];
                    console.log('file', file)
                    const newFile = new File([blob], file.name, { type: 'image/png' });
                    formData.append('save_images[]', newFile);
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
            console.log('save_images', Object.keys(save_images))
        })



        // if(files) {
        //     files.forEach(async (v, k) => {
        //         await new Promise((resolve, reject) => {
        //             let reader = new FileReader();
        //             let file = v.files[0];
        //             reader.readAsDataURL(v.files[0]);
        //             reader.onload = async () => {
        //                 const imgData = reader.result;
        //                 let image = new Image();
        //                 image.src = imgData;

        //                 const canvas = document.createElement('canvas');
        //                 canvas.width = 200;
        //                 canvas.height = 200;
        //                 const ctx = canvas.getContext('2d');
        //                 ctx.drawImage(image, 0, 0, 200, 200);
        //                 const resizedImgData = canvas.toDataURL('image/png')
        //                 const blob = base64ImgToBlob(resizedImgData, 'image/png');
        //                 const newFile = new File([blob], file.name,{ type: 'image/png' })
        //                 console.log('resizedImgData', resizedImgData)
        //                 save_images[k] = newFile;
        //                 // formData.append('save_images[]', newFile);
        //             };
        //         });
        //     })
        // }


        // if(imgList) {
        //     imgList.forEach(async (v, k) => {
        //         let file = v.files[0];
        //         console.log('file', file)
        //         if(file) {
        //             let image = new Image();
        //             image.src = URL.createObjectURL(file);
        //             const base64 = resizeImgToBase64(image);




        //             new Promise((resolve, reject) => {
        //                 const reader = new FileReader();
        //                 reader.readAsDataURL(file);
        //                 reader.onload = () => resolve(reader.result);
        //                 reader.onerror = error => reject(error);
        //               }).then((data) => {
        //                 const blob = base64ImgToBlob(data, file.type);
        //                 const newFile = new File([blob], file.name,{ type: file.type })
        //                 formData.append('save_images[]', newFile);
        //               });



        //             // console.log('submitValidateForm base64', reader);

        //         }
        // //

        //         // let response = await fetch(base64)
        //         // .then(res => res.blob())
        //         // .then(blob => {
        //         //     const newFile = new File([blob], file.name,{ type: "image/png" })
        //         //     // formData.append('save_images[]', newFile);
        //         //     // let fileInput = document.createElement('input');
        //         //     // fileInput.type = 'file';
        //         //     // fileInput.name = 'save_image[]';
        //         //     // fileInput.value = JSON.stringify(newFile);
        //         //     // v.closest('.img-group').append(fileInput);
        //         //     console.log('submitValidateForm file', file);
        //         //     return newFile;
        //         // });
        //         // console.log('submitValidateForm response', response);
        //         // formData.append('save_images[]', newFile);
        // //         // const reader = new FileReader();
        // //         // reader.onload = function(event) {


        // //         // }
        // //         // reader.readAsDataURL(file);
        // //         console.log('submitValidateForm file', v.files)
        //     });
        // }
        // for(const fd of formData.entries()) {
        //     console.log(`key:${fd[0]}-val:${fd[1]}`)
        // }
        // formData.delete('image_products[]');
        // // // sendPostForm(e.target.action, formData);
        // // // console.log('submitValidateForm save_images', save_images)

        //     let callback = (data) => {
        //         console.log('data', data)
        //         let errors = data.errors;
        //         if(document.querySelector('.message.error')) document.querySelector('.message.error').remove();
        //         if(document.querySelector('.message.success')) document.querySelector('.message.success').remove();
        //         if(Object.keys(errors).length) {
        //             for(const error of Object.entries(errors)) {
        //                 for(const err_mess of Object.entries(error[1])) {
        //                     let errorElm = document.createElement('div');
        //                     errorElm.classList = 'message error';
        //                     errorElm.onclick = this.classList.add('hidden');
        //                     errorElm.innerText = err_mess[1];
        //                     document.querySelector('.container .row').before(errorElm);
        //                     window.scrollTo(0,0);
        //                     return;
        //                 }

        //             }
        //         } else {
        //             let errorElm = document.createElement('div');
        //             errorElm.classList = 'message success';
        //             errorElm.onclick = this.classList.add('hidden');
        //             errorElm.innerText = 'The product has been saved.';
        //             document.querySelector('.container .row').before(errorElm);
        //             window.scrollTo(0,0);
        //         }

        //     };

        //     // console.log('save_images', save_images)
        //     // save_images.forEach((v, k) => {
        //     //     formData.append(`save_images-${k}`, v)
        //     // })

        // await new Promise((resolve, reject) => {
        //     console.log('save_images aaa', save_images)
        //     console.log('save_images aaa', Object.keys(save_images))
        //     for(const img of Object.entries(save_images)) {
        //         console.log('img', img)
        //     }
        //     // postFetch(e.target.action, formData, callback, save_images);
        // })


    }



    function postFetch(url, data, callback, headers = null) {
        // console.log('headers', headers)
        // console.log('header', typeof headers)
        // console.log('header', Object.entries(Object.fromEntries(headers)))
        // headers.map((v, k) => {
        //     console.log('header', v)
        //     formData.append(`save_images-${k}`, v)
        // })
        // for(const h of headers) {
        //     console.log(`key:${h[0]}-val:${h[1]}`)
        // }
        // for(const fd of data.entries()) {
        //     console.log(`key:${fd[0]}-val:${fd[1]}`)
        // }
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
        imgGroup.classList = 'd-grid gap-2 img-group mb-2';
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
        deleteBtn.innerText = 'Delete';
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-danger mx-2 d-none delete-image-button';
        deleteBtn.addEventListener('click', removeUploadedImg);
        showImg.append(imgDiv);
        showImg.append(deleteBtn);
        imgGroup.append(showImg);

        let imageFileList = document.querySelector('.input.file');
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

    function removeUploadedImg(e) {
        e.target.closest('.img-group').remove();
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

    /* コードの終了 */
})();
