<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>出版社データ追加処理スクリプト</title>
    </head>
    <body>
        <!-- ここからPHPスクリプトの開始 -->
        <?php

            // フォームから渡された引数を取得
            $publisher = $_GET[publisher];
            $pubpage = $_GET[pubpage];

            // データベースに接続
            $conn = pg_connect("dbname=abcw2059");

            // 接続が成功したかどうか確認
            if($conn == null){
                print("データベース接続処理でエラーが発生しました。<br>");
                exit;
            }

            // データ挿入のSQLを作成
            $sql = sprintf(
                "insert into publish(publisher, pubpage)
                values('%s','%s');",
                $publisher, $pubpage
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

        <p>データの追加処理が完了しました。</p>
        <br>

        <a href="index.html">操作メニューに戻る</a>
    </body>
</html>