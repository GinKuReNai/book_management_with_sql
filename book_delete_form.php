<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>書籍の削除フォーム</title>
    </head>
    <body>
        <center>
            <h2>書籍データ 削除フォーム</h2>
            <br><br>

            <p>削除したい書籍を選択して送信ボタンを押してください。</p>
            <br><br>

            <form action="book_delete.php" method="get">
                <!-- ここからPHPスクリプトの開始 -->
                <?php
                // データベースに接続
                $conn = pg_connect("dbname=abcw2059");

                // 接続が成功したかどうかの確認
                if($conn == null){
                    print("データベース接続処理でエラーが発生しました。<br>");
                    exit;
                }

                // SQLを作成
                $sql = "
                select book.title, book.publisher, class.classname, book.author1, book.author2, book.author3, publish.pubpage, book.finishdate, book.status 
                from book, publish, class 
                where book.publisher = publish.publisher and book.classnum = class.classnum";

                // Queryを実行して検索結果をresultに格納
                $result = pg_query($conn, $sql);
                if($result == null){
                    print("クエリの実行処理でエラーが発生しました。<br>");
                    exit;
                }

                // 検索結果の行数、列数を取得
                $rows = pg_num_rows($result);
                $cols = pg_num_fields($result);

                // 検索結果をテーブルとして表示
                print("<table border=1>\n");

                // 各列の名前を表示
                print("<tr>");
                print("<th>タイトル</th>");
                print("<th>出版社</th>");
                print("<th>分類名</th>");
                print("<th>著者1人目</th>");
                print("<th>著者2人目</th>");
                print("<th>著者3人目</th>");
                print("<th>出版社ページ</th>");
                print("<th>読了日</th>");
                print("<th>状態</th>");
                print("</tr>");

                // 各行のデータを表示
                for($i = 0; $i < $rows; $i++){
                    print("<tr>");

                    // 書籍の選択のためのラジオボタンを表示
                    $data = pg_fetch_result($result, $i, 0);
                    print("<td><input type=\"radio\" name=\"title\" value=\"$data\">$data</input></td>");
                    $data = pg_fetch_result($result, $i, 1);
                    print("<td><input type=\"hidden\" name=\"publisher\" value=\"$data\">$data</input></td>");
                    for($j = 2; $j < $cols; $j++){
                        $data = pg_fetch_result($result, $i, $j);

                        if($j == 6){
                            print("<td><a href=\"$data\">出版社HP</a></td>");
                        }
                        else{
                            print("<td>$data</td>");
                        }
                    }
                    print("</tr>");
                }

                // ここまででテーブル終了
                print("</table>");
                print("<br>\n");

                // 検索件数の表示
                print("以上、$rows 件の書籍が登録されています。<br>\n");

                // 検索結果の開放
                pg_free_result($result);
                // データベースへの接続を解除
                pg_close($conn);

                ?>
                <!-- ここまででPHPスクリプトの終わり -->

                <br>
                <input type="submit" value="送信"><br>
            </form>

            <br>
            <a href="index.html">操作メニューに戻る</a>
        </center>
    </body>
</html>