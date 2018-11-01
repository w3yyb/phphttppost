<?php
function http_post_data($url, $data_string, $json = false)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    if ($json) {
        curl_setopt($ch, CURLOPT_HEADER, 0); //json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Content-Length:'.strlen($data_string)));//json
    }
    ob_start();
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();
    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return array($return_code, $return_content);
}
$url =isset($_POST['url'])?$_POST['url']:'';
$data =isset($_POST['data'])?$_POST['data']:'';
$json =isset($_POST['json'])?$_POST['json']:false;

if ($_POST) {
    list($return_code, $return_content) = http_post_data($url, $data, $json);
    var_dump($return_code);
    echo "<br>";
    var_dump($return_content);
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
    
    <head>
        <meta charset="utf-8">
        <title>HTTP POST 调试工具</title>
        <meta http-equiv=X-UA-Compatible content="IE=edge,chrome=1">
        <meta name="author" content="Lenix">
    </head>
    
    <body>
        <center>HTTP POST 调试工具
            <form action="" method="post">
                <table>
                    <tr>
                        <td>url:</td>
                        <td>
                            <input type=text name="url" size=60 id="url">
                        </td>
                    </tr>
                    <tr>
                        <td>data:</td>
                        <td>
                            <textarea name="data" rows="10" cols="62" id="textdata"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>json:格式
                            <input type="checkbox" value="1" name="json">
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2 align=center>
                            <input type="submit">
                            <input type="button" value="清除" onclick="cleartext()" />
                        </td>
            </form>
            </tr>
            </table>



<script type="text/javascript">

if (!localStorage.getItem("url")) {
localStorage.setItem("url", '<?=$_POST['url'] ?? '' ;?>');
}
if (!localStorage.getItem("textcontent")) {
localStorage.setItem("textcontent", `<?=$_POST['data']?? '' ;?>`);
}
verify();   //验证本地存储

//自定义验证函数，验证 的数据是否存在
function verify(){
    var url = localStorage.getItem("url");
    var textdata = localStorage.getItem("textcontent");
    url = url ? url : '';
    textdata = textdata ? textdata : '';
    document.getElementById("url").value = url;
    document.getElementById("textdata").value = textdata;

}
function cleartext() {
    localStorage.removeItem("url");
    localStorage.removeItem("textcontent");
    //localStorage.clear();
    document.getElementById("url").value = '';
    document.getElementById("textdata").value = '';

}
</script>


