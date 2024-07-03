//バナーのボタン切替
document.addEventListener("DOMContentLoaded", function() {
    // ボタンのイベントリスナーを設定
    document.getElementById('btn2').addEventListener('click', function() {
        changeImage(1); // 1番目の画像に切り替える
    });

    document.getElementById('btn1').addEventListener('click', function() {
        changeImage(2); // 2番目の画像に切り替える
    });
});

function changeImage(imageIndex) {
    var headerContainer = document.getElementById('header-container');
    var images = headerContainer.getElementsByTagName('img');

    // 現在表示されている画像を非表示に
    for (var i = 0; i < images.length; i++) {
        images[i].style.display = 'none';
    }

    // 指定された画像を表示
    images[imageIndex - 1].style.display = 'block'; // インデックスは1から始まるため、-1する
}

//ソート機能
document.addEventListener('DOMContentLoaded', function() {
    const sortButton = document.querySelector('#sortButton');

    sortButton.addEventListener('click', function() {
        fetch('/articles/sorted')
            .then(response => response.json())
            .then(data => {
                const noticeList = document.querySelector('.notice-list');
                noticeList.innerHTML = '';

                data.forEach(article => {
                    const card = document.createElement('div');
                    card.className = 'card mb-3';
                    card.innerHTML = `
                        <div class="card-body">
                            <p>${article.article_contents.substring(0, 100)}</p>
                            <a href="/articles/${article.id}" class="btn btn-primary">続きを読む</a>
                        </div>
                    `;
                    noticeList.appendChild(card);
                });
            })
            .catch(error => console.error('Error:', error));
    });
});

