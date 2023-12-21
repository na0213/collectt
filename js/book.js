const btn = document.getElementById("btn");

btn.addEventListener('click', async() => {
    // フォームに入力されたテキストの取得
    const textValue = document.getElementById("formText").value;
    // 書籍検索ができるGoogle Books APIのエンドポイントにフォームから取得したテキストを埋め込む
    const res = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${textValue}`);
    const data = await res.json();
    const bookItem = document.getElementById("bookItem");
    for(let i = 0; i < data.items.length; i++){
        // 例外が起きなければtryブロック内のコードが実行される
        try{
            // JSONデータの取得
            // 画像を表示するリンク
            const bookImg = data.items[i].volumeInfo.imageLinks.smallThumbnail;
            // 本のタイトル
            const bookTitle = data.items[i].volumeInfo.title;
            // 本の説明文
            const bookContent = data.items[i].volumeInfo.description;
            // 各書籍のGoogle Booksへのリンク
            const bookLink = data.items[i].volumeInfo.infoLink;
            // 取得したデータを入れるための要素を作成
            const makeElement = document.createElement("div");
            // 要素別に識別できるようにidに数字を埋め込む
            makeElement.setAttribute("id", `bookItem${i}`);
            // 取得した要素に作成した要素を挿入
            bookItem.appendChild(makeElement);
            // 作成した要素を習得
            const getBookItem = document.getElementById(`bookItem${i}`);
            // APIで取得したデータの分だけHTML要素を作成し、取得した要素にを埋め込む
            const setBookElement = `
                <div class="book-area">
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <img src="${bookImg}"><br>
                                <a id="link${i}" class="card-text" target="_blank">${bookTitle}</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p>${bookContent}</p>
                                </div>
                            </div>
                            <div class="cardbutton">
                                <button onclick="registerBook('${bookTitle}', '${bookImg}')">COLE</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            // APIから取得した、実際のGoogle Booksのサイトに飛ばすためのリンクを埋め込む
            getBookItem.innerHTML = setBookElement;
            const link = document.getElementById(`link${i}`);
            link.href = bookLink;
            // 途中で例外が発生した場合はcatchブロック内のコードが実行される
        }catch(e){
            continue;
        };
    };
});

function registerBook(title, img) {
    const data = { title: title, image: img };

    fetch('savebook.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


// function registerBook(title, img) {
//     const parameter = {
//         name: title,
//         image: img
//     };

//     fetch('mybook.php', 
//     {
//         method: 'POST', // HTTP-メソッドを指定
//         headers: { 'Content-Type': 'application/json' }, // jsonを指定
//         body: JSON.stringify(parameter),
//     }
//     ) // Serverから返ってきたレスポンスをjsonで受け取って、次のthenに渡す
//     .then(response => {
//         if (response.ok) {
//             return response.json();
//         } else {
//             throw new Error('Server responded with a non-OK status');
//         }
//     })
//     .then(res => {
//         console.log({res});
//     })
//     .catch(error => {
//         console.log({error});
//     });
// }