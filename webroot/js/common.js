(function(){
    /* コードの開始 */

    document.addEventListener('DOMContentLoaded', function() {
        customizeInputFileItem();

        let btnAction = document.getElementById('add-image-button')
        if(btnAction) btnAction.addEventListener('click', addInputFile);

        let cards = document.querySelectorAll('.card');
        if(cards) {
            cards.forEach((card, k) => {
                card.addEventListener('click', cardRedirectUrl)
            });
        }
    }, false);




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
        let showImg = e.target.closest('.img-group').querySelectorAll('.show-image .image');
        let img = document.createElement('img');
        let image = e.target.files[0];
        img.src = URL.createObjectURL(image);
        showImg[0].append(img);
        e.target.closest('.img-group').querySelectorAll('.show-image .delete-image-button')[0].classList.remove('d-none');
        console.log('filechange', showImg)
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

    /* コードの終了 */
})();
