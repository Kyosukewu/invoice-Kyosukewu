<?php
include_once("base.php");
//期別查詢
$get_new = $pdo->query("select * from `award_numbers` order by year desc,period desc limit 1")->fetch();
$nyear = $get_new['year'];
$nperiod = $get_new['period'];
$year =  !empty($_GET['p']) ? explode("-", $_GET['p'])[0] : $nyear;
$period = !empty($_GET['p']) ? explode("-", $_GET['p'])[1] : $nperiod;
//資料分頁
$pageSize = 19; //每頁幾條紀錄
$rowCount = $pdo->query("select count(period) from `invoices` where period='$period'")->fetch(); //共幾條紀錄
$pageNow = 1; //顯示第幾頁
$pageCount = ceil($rowCount[0] / $pageSize); //共多少頁
if (!empty($_GET['pageNow'])) {
    $pageNow = $_GET['pageNow'];
}
$pageStart = ($pageNow - 1) * $pageSize; //目前頁面

$sql = "select * from `invoices` where period='$period' Order by date desc limit $pageStart,$pageSize";
// $sql="select * from `invoices` order by date desc";

$rows = $pdo->query($sql)->fetchall();

// foreach($rows as $row){
//     echo $row['code']."-".$row['number']."<br>";
// }
?>
<div class="rightPage h-100 d-flex flex-column justify-content-between">
<div class="path">
        <div class="pagination pagination-sm justify-content-center align-items-end mt-lg-2">
            <li class="page-item">
                <a class="page-link" href="?do=api/check_awards&pd=<?=$year?>-<?= $period - 1; ?>">
                    <span aria-hidden="true" class="text-dark fas fas fa-angle-left"></span>
                </a>
            </li>
            <li class="page-item">
                <form class="d-flex" action="index.php" method="get">
                    <select name="y" onchange="submit();" class="form-select form-select-sm text-dark">
                        <option value="<?= $year-1 ?>"><?= $year-1 ?></option>
                        <option value="<?= $year ?>" selected><?= $year ?></option>
                        <option value="<?= $year+1 ?>"><?= $year+1 ?></option>
                    </select>
                    <select name="p" onchange="submit();" class="form-select form-select-sm text-dark">
                        <?php
                        for ($i = 1; $i < 7; $i++) {
                            if($i==$period){
                                echo "<option value='$i' selected>";
                            }else{
                                echo "<option value='$i'>";
                            }
                            echo "$month[$i]" . "</option>";
                        }
                        ?>
                    </select>
                </form>
            </li>
            <li class="page-item">
                <a class="page-link" href="?do=api/check_awards&pd=<?=$year?>-<?= $period + 1; ?>">
                    <span aria-hidden="true" class="text-dark fas fa-angle-right"></span>
                </a>
            </li>
        </div>
    </div>
    <!-- <div class="path mb-2">
        <nav class="navbar navbar-light justify-content-evenly">
            <a href="?p=1"><button class="btn btn-sm btn-outline-secondary" type="button">1-2月</button></a>
            <a href="?p=2"><button class="btn btn-sm btn-outline-secondary" type="button">3-4月</button></a>
            <a href="?p=3"><button class="btn btn-sm btn-outline-secondary" type="button">5-6月</button></a>
            <a href="?p=4"><button class="btn btn-sm btn-outline-secondary" type="button">7-8月</button></a>
            <a href="?p=5"><button class="btn btn-sm btn-outline-secondary" type="button">9-10月</button></a>
            <a href="?p=6"><button class="btn btn-sm btn-outline-secondary" type="button">11-12月</button></a>
        </nav>
    </div> -->


    <div class="inv">
        <div class="tit d-flex w-100 py-2 mb-3 border-top">
            <div class="t1 text-center">發票號碼</div>
            <div class="t2 text-center">消費日期</div>
            <div class="t3 text-center">金額</div>
            <div class="t4 text-center d-none d-md-block">操作</div>
        </div>
        <div class="invoices w-100">
            <?php
            foreach ($rows as $row) {
            ?>
                <div class="invoice d-flex flex-wrap">
                    <div class="t1 text-center"><?= $row['code'] . "-" . $row['number'] ?></div>
                    <div class="t2 text-center  text-secondary"><?= $row['date'] ?></div>
                    <div class="t3 text-center"><?= $row['payment'] ?></div>
                    <div class="t4 text-center d-none d-md-block">
                        <a href="?do=edit_invoice&id=<?= $row['id']; ?>">
                            <button type="button" data-toggle="tooltip" data-placement="top" title="編輯" class="btn btn-sm btn-outline-warning">
                                <p class="far fa-edit"></p>
                            </button>
                        </a>
                        <a href="?do=del_invioce&id=<?= $row['id']; ?>"><button type="button" data-toggle="tooltip" data-placement="top" title="刪除" class="btn btn-sm btn-outline-danger">
                                <p class="fas fa-trash-alt"></p>
                            </button>
                        </a>
                        <a href="?do=award&id=<?= $row['id']; ?>"><button type="button" data-toggle="tooltip" data-placement="top" title="對獎" class="btn btn-sm btn-outline-success">
                                <p class="fas fa-medal"></p>
                            </button>
                        </a>
                    </div>
                    <div class="t5 text-center d-flex align-items-center d-md-none w-100 mb-3">
                        <div class="contral w-100 text-right mt-1 mr-4">
                            <a href="?do=edit_invoice&id=<?= $row['id']; ?>">
                                <button type="button" data-toggle="tooltip" data-placement="top" title="編輯" class="btn btn-sm btn-outline-warning">
                                    <span class="far fa-edit"></span><span> 編輯</span>
                                </button>
                            </a>
                            <a href="?do=del_invioce&id=<?= $row['id']; ?>"><button type="button" data-toggle="tooltip" data-placement="top" title="刪除" class="btn btn-sm btn-outline-danger">
                                    <span class="fas fa-trash-alt"></span><span> 刪除
                                    </span>
                                </button>
                            </a>
                            <a href="?do=award&id=<?= $row['id']; ?>"><button type="button" data-toggle="tooltip" data-placement="top" title="對獎" class="btn btn-sm btn-outline-success">
                                    <span class="fas fa-medal"></span><span> 對獎
                                    </span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    $prePage = $pageNow - 1;

    if ($pageNow < $pageCount) {
        $nextPage = $pageNow + 1;
    } else {
        $nextPage = $pageCount;
    }
    ?>
    <div class="page pagination pagination-sm justify-content-center align-items-end mb-0 mb-md-2 mt-lg-2">
        <li class="page-item">
            <a class="page-link" href="?pageNow=<?= $pageNow = 1; ?>&p=<?= $period; ?>" aria-label="Previous">
                <span aria-hidden="true" class="text-dark fas fa-angle-double-left"></span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?pageNow=<?= $prePage; ?>&p=<?= $period; ?>" aria-label="Previous">
                <span aria-hidden="true" class="text-dark fas fas fa-angle-left"></span>
            </a>
        </li>
        <li class="page-item">
            <form action="index.php" method="get">
                <input type="hidden" name="p" value="<?= $period ?>">
                <select name="pageNow" onchange="submit();" class="form-select form-select-sm text-dark">
                    <?php
                    for ($i = 1; $i <= $pageCount; $i++) {
                        echo "<option value='$i'>Page-" . $i . "</option>";
                    }
                    ?>
                </select>
            </form>
        </li>
        <li class="page-item">
            <a class="page-link" href="?pageNow=<?= $nextPage; ?>&p=<?= $period; ?>" aria-label="Next">
                <span aria-hidden="true" class="text-dark fas fa-angle-right"></span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?pageNow=<?= $pageNow = $pageCount; ?>&p=<?= $period; ?>" aria-label="Next">
                <span aria-hidden="true" class="text-dark fas fa-angle-double-right"></span>
            </a>
        </li>
    </div>
</div>