<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>書籍データ更新処理スクリプト</title>
    </head>
    <body>
        <!-- ここからPHPスクリプトの開始 -->
        <?php
            // フォームから渡された引数を取得
            $title = $_GET[title];
            $publisher = $_GET[publisher];
            $classnum = $_GET[classnum];
            $author1 = $_GET[author1];
            $author2 = $_GET[author2];
            $author3 = $_GET[author3];
            $finishdate = $_GET[finishdate];
            $status = $_GET[status];

            // データベースに接続
            $conn = pg_connect("dbname=abcw2059");

            // 接続が成功したかどうか確認
            if($conn == null){
                print("データベース接続処理でエラーが発生しました。<br>");
                exit;
            }

            // データ更新のSQLを作成
            $sql = sprintf(
                "update book
                 set classnum = '%s', author1 = '%s', author2 = '%s', author3 = '%s', finishdate = '%s', status = '%s'
                 where title = '%s' and publisher = '%s'",
                 $classnum, $author1, $author2, $author3, $finishdate, $status, $title, $publisher
            );

            // 確認用のメッセージ表示
            print("<p>クエリー「");
            print($sql);
            print("」を実行します。<br>");

            // Queryを実行して検索結果をresultに格納
            $result = pg_query($conn, $sql);
            if($result == null){
                print("クエリー実行処理でエラーが発生しました。<br>");
                exit;
            }

            // 検索結果の開放
            pg_free_result($result);
            // データベースへの接続を解除
            pg_close($conn);
        ?>
        <!-- ここまででPHPスクリプトの終わり -->

        <p>データの更新処理が完了しました。</p>
        <br>

        <a href="index.html">操作メニューに戻る</a>
    </body>
</html>
