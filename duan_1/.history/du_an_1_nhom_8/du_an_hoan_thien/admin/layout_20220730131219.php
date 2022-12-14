<?php 
    require "$DAO_URL/pdo.php";
    require "$DAO_URL/sign_up_login/login.php";
    $sql = "SELECT * FROM truyen";      
    $truyen = select_all ($sql);     
    
    if (isset($_SESSION['user'])) {
        $sqlNotify = "SELECT * FROM `notify` WHERE idUser LIKE '%".$_SESSION['user']['idUser']."%' AND idUserXoa NOT LIKE '%".$_SESSION['user']['idUser']."%';";
        $notify = select_all($sqlNotify);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$pageName?></title>
    <link rel="icon" href="https://metruyenchu.com/assets/images/logo.png?260329">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src="https://kit.fontawesome.com/cf5472ea14.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?=$CONTENT_URL?>/CSS/public.css">
    <link rel="stylesheet" href="<?=$CONTENT_URL?>/CSS/index.css">
    <link rel="stylesheet" href="<?=$CONTENT_URL?>/CSS/home-content.css">
    <link rel="stylesheet" href="<?=$CONTENT_URL?>/CSS/responsive.css">
   
    </head>
<body>
    
    <div class="container-fluid p-xl-0 p-lg-0 p-md-0">
        <div class="container-fluid" style="background: var(--back-color);">
            <div class="container">
                <!-- =======Header======== -->
                <header class="header d-none d-xl-flex d-lg-flex">
                    <div class="header__left">
                        <a href="<?=$USER_URL?>/trangchu/index.php" class="header__logo logo">
                            <img src="https://metruyenchu.com/assets/images/logo.png?260329" alt="">
                        </a>
                        <!-- ======category======= -->
                        <div class="header__category">
                            <div class="block-icon header__category-icon">
                                <i class="fas fa-bars"></i>
                                <span>Th??? Lo???i</span>
                            </div>
    
                            <div class="header__category-content category">
                                <div class="category-item">
                                    <a href="<?=$USER_URL?>/loctruyen/index.php" class="category-item-link">T???t C???</a>
                                </div>
                                <?php
                                    $sqlNhom1 = "SELECT * FROM danhMuc WHERE nhom='nhom1'";
                                    $nhom1 = select_all($sqlNhom1);
                                    foreach ($nhom1 as $k => $n1) :
                                    extract($n1);
                                ?>
                                <div class="category-item">
                                    <a href="<?=$USER_URL?>/loctruyen/index.php?idDanhMuc=<?=$idDanhMuc?>" class="category-item-link"><?=$tenDanhMuc?></a>
                                </div>
                                <?php endforeach?>
                            </div>
                        </div>

                        <!-- ===========rank========== -->
                        <a href="<?=$USER_URL?>/rank/index.php" class="header__rank">
                            <div class="header__rank-text">B???ng X???p H???ng</div>
                        </a>
                    </div>
                    <!-- ===========search========= -->
                    <div class="header__search">
                        <form class="header__search-input">
                            <input type="text" name="header__search-input" autocomplete="off" placeholder="Nh???p t??n truy???n ho???c t??c gi???">
                            <i class="fas fa-search header__search-icon"></i>

                            <!-- === history === -->
                            <div class="category header__search-history"></div>
                        </form>
                        
                    </div>
    
                    <div class="header__right">
                        <a href="<?=$ADMIN_URL?>/truyen/indexAdminTruyen.php" class="header__upload">
                            <div class="block-icon">
                                <i class="fas fa-upload"></i>
                                <span>????ng Truy???n</span>
                            </div>
                        </a>
        
                        <?php if (!isset($_SESSION['user'])) :?>
                        <!-- ========????ng nh???p,????ng k??=========== -->
                        <div class="header__login header__form">????ng Nh???p</div>
                        <div class="header__register header__form">????ng K??</div>
                        <?php endif?>

                        <?php if (isset($_SESSION['user'])) :?>
                        <!-- ======notify===== -->
                        <div class="header__notify">
                            <div class="header__notify-icon">
                                <i class="fas fa-bell"></i>
                                <?php 
                                    $sqlNoReadNotify = "SELECT * FROM `notify` WHERE idUser LIKE '%".$_SESSION['user']['idUser']."%' AND idUserDoc NOT LIKE '%".$_SESSION['user']['idUser']."%' AND idUserXoa NOT LIKE '%".$_SESSION['user']['idUser']."%'";
                                    $notifyNoRead = select_all($sqlNoReadNotify);
                                ?>
                                <?php if (isset($notifyNoRead) && count($notifyNoRead) > 0) :?>
                                    <div class="notify-number"><?=count($notifyNoRead) < 100 ? count($notifyNoRead) : '99'?></div>
                                <?php endif?>
                            </div>
                            
                            <ul class="header__notify-content-main category">
                                <?php if (isset($notify)) :?>
                                    <?php foreach ($notify as $k => $noti) :?>
                                        <?php
                                            extract($noti);
                                            if ($kieuNotify == 0) :?>
                                                
                                                <?php if (exist_string($idUserDoc,$_SESSION['user']['idUser'])) :?>
                                                    <li class="category-item <?=exist_string($idUserDoc,$_SESSION['user']['idUser']) ? 'watched' : '' ?> " style="cursor: default;">
                                                        <div class="icon-cricle"></div>
                                                        <div class="category-item-link"><?=$tieuDe?></div>
                                                    </li>
                                                <?php endif?>

                                                <?php if (!exist_string($idUserDoc,$_SESSION['user']['idUser'])) :?>
                                                    <li class="category-item">
                                                        <div class="icon-cricle"></div>
                                                        <a href="<?=$DAO_URL?>/notify/read_notify.php?typeNoti=one&linkNoti=<?=$link?>&idUser=<?=$_SESSION['user']['idUser']?>&idNotify=<?=$idNotify?>" class="category-item-link"><?=$tieuDe?></a>
                                                    </li>
                                                <?php endif?>
                                        <?php continue;
                                            endif
                                        ?>

                                        <?php
                                            extract($noti);
                                            if ($kieuNotify == 1) :
                                                $linkNoti1 = "$USER_URL/truyen/index.php?idTruyen=$idTruyen";
                                            ?>
                                                <li class="category-item <?=exist_string($idUserDoc,$_SESSION['user']['idUser']) ? 'watched' : '' ?>">
                                                    <div class="icon-cricle"></div>
                                                    <a href="<?=$DAO_URL?>/notify/read_notify.php?typeNoti=one&linkNoti=<?=$linkNoti1?>&idUser=<?=$_SESSION['user']['idUser']?>&idNotify=<?=$idNotify?>" class="category-item-link"><?=$tieuDe?></a>
                                                </li>
                                        <?php continue;
                                            endif
                                        ?>

                                        <?php
                                            extract($noti);
                                            if ($kieuNotify == 2) :
                                                $linkNoti2 = "$USER_URL/usermanager/index.php?idUser=".$_SESSION['user']['idUser']."";
                                            ?>
                                                <li class="category-item <?=exist_string($idUserDoc,$_SESSION['user']['idUser']) ? 'watched' : '' ?>">
                                                    <div class="icon-cricle"></div>
                                                    <a href="<?=$DAO_URL?>/notify/read_notify.php?typeNoti=one&linkNoti=<?=$linkNoti2?>&idUser=<?=$_SESSION['user']['idUser']?>&idNotify=<?=$idNotify?>" class="category-item-link"><?=$tieuDe?></a>
                                                </li>
                                        <?php continue;
                                            endif
                                        ?>
                                    <?php endforeach?>
                                <?php endif?>
                                <?php if (count($notify) == 0) :?>
                                    <li class="category-item notify-hollow">
                                        <i class="fas fa-box-open"></i>
                                        <span>B???n ch??a c?? th??ng b??o n??o!</span>
                                    </li>
                                <?php endif?>
                                <a href="<?=$USER_URL?>/usermanager/index.php?idUser=<?=$_SESSION['user']['idUser']?>" class="header__notify-content-footer">
                                    <span>Xem t???t c???</span>
                                </a>
                            </ul>
                            
                        </div>
    
                        <!-- ========user======== -->
                        <div class="header__user">
                            <div class="header__user-avt">
                                <img src="<?=$CONTENT_URL?>/IMG/<?=$_SESSION['user']['imgUser']?>" alt="">
                            </div>
                            <div class="header__user-name">
                                <div class="header__user-name-text limit1"><?=$_SESSION['user']['userName']?></div>
                            </div>
    
                            <div class="header__user-content category">
                                <div class="category-item">
                                    <a href="<?=$USER_URL?>/usermanager/index.php?idUser=1" class="category-item-link">H??? S??</a>
                                </div>
                                <div class="category-item">
                                    <a href="" class="category-item-link">T??? Truy???n</a>
                                </div>
                                <div class="category-item">
                                    <a href="" class="category-item-link">C??i ?????t</a>
                                </div>
                                <div class="category-item">
                                    <a href="" class="category-item-link">Nh???n Th?????ng</a>
                                </div>
                                <div class="category-item">
                                    <a href="<?=$DAO_URL?>/sign_up_login/logout.php?link=<?=$link?>" class="category-item-link">????ng Xu???t</a>
                                </div>
                            </div>
                        </div>
                        <?php endif?>
                    </div>
                </header>
    
                <header class="header__responsive d-lg-none">
                    <a href="index.html" class="header__responsive-logo">
                        <img src="https://metruyenchu.com/assets/images/logo-domain.png?260329" alt="">
                    </a>
    
                    <input type="checkbox" id="check__search-responsive" hidden>
                    <input type="checkbox" id="check__nav-responsive" hidden>
                    <div class="header__responsive-right">
                        <label for="check__search-responsive" class="header__responsive-search" style="margin-bottom: 0;">
                            <div class="header__responsive-search-icon">
                                <i class="fas fa-search"></i>
                                <i class="fa-solid fa-x"></i>
                            </div>
                        </label>
                        <label for="check__nav-responsive" class="mb-0 header__responsive-nav">
                            <i class="fas fa-bars"></i>
                            <i class="fa-solid fa-x"></i>
                        </label>
                    </div>
                    <div class="header__responsive-search-content">
                        <div class="header__responsive-search-input">
                            <form action="" method="post">
                                <input type="text" placeholder="T??m ki???m t??n truy???n ho???c t??n t??c gi???">
                                <div class="header__responsive-search-input-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                            </form>
                        </div>
                    </div>
    
                    <div class="header__responsive-nav-content">
                        <input type="checkbox" id="check__nav-rank-child" hidden>
                        <input type="checkbox" id="check__nav-category-child" hidden>
                        <div class="header__responsive-nav-item">
                            <div class="header__responsive-nav-item-text header__login">????ng Nh???p</div>
                        </div>
                        <div class="header__responsive-nav-item">
                            <div class="header__responsive-nav-item-text header__register">????ng K??</div>
                        </div>
                        <div class="header__responsive-nav-item">
                            <div class="header__responsive-nav-item-icon">
                                <i class="fa-solid fa-ranking-star"></i>
                            </div>
                            <label for="check__nav-rank-child" class="mb-0 header__responsive-nav-item-text">B???ng X???p H???ng</label>
                            <div class="header__responsive-nav-item-icon ml-auto">
                                <i class="fa-solid fa-angle-down"></i>
                            </div>
                        </div>
    
                        <div class="header__responsive-nav-item-child check__nav-rank-child">
                            <div class="header__responsive-nav-item-child-text">?????c Nhi???u</div>
                            <div class="header__responsive-nav-item-child-text">T???ng Th?????ng</div>
                            <div class="header__responsive-nav-item-child-text">????? C???</div>
                            <div class="header__responsive-nav-item-child-text">Y??u Th??ch</div>
                            <div class="header__responsive-nav-item-child-text">Th???o Lu???n</div>
                        </div>
                        <div class="header__responsive-nav-item">
                            <div class="header__responsive-nav-item-icon">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </div>
                            <label for="check__nav-category-child" class=" mb-0 header__responsive-nav-item-text">Th??? Lo???i</label>
                            <div class="header__responsive-nav-item-icon ml-auto">
                                <i class="fa-solid fa-angle-down"></i>
                            </div>
                        </div>
                        <div class="header__responsive-nav-item-child check__nav-category-child">
                            <a href="HTML/category.html" class="header__responsive-nav-item-child-text">T???t C???</a>
                            <div class="header__responsive-nav-item-child-text">Huy???n Huy???n</div>
                            <div class="header__responsive-nav-item-child-text">Ti??n Hi???p</div>
                            <div class="header__responsive-nav-item-child-text">V??ng Du</div>
                            <div class="header__responsive-nav-item-child-text">C???nh K???</div>
                            <div class="header__responsive-nav-item-child-text">?????ng Nh??n</div>
                            <div class="header__responsive-nav-item-child-text">Trinh Th??m</div>
                            <div class="header__responsive-nav-item-child-text">?????i Th?????ng</div>
                            <div class="header__responsive-nav-item-child-text">Tr???ng Sinh</div>
                            <div class="header__responsive-nav-item-child-text">M???t Th???</div>
                            <div class="header__responsive-nav-item-child-text">Huy???n Nghi</div>
                            <div class="header__responsive-nav-item-child-text">K??? ???o</div>
                        </div>
                    </div>
    
                    <div class="header__responsive-bar">
                        <div class="row w-100" style="padding: 0 15px;">
                            <div class="col-4">
                                <a href="" class="header__responsive-bar-item">
                                    <div class="header__responsive-bar-icon">
                                        <i class="fa-solid fa-table-cells-large"></i>
                                    </div>
                                    <div class="header__responsive-bar-text">Danh S??ch</div>
                                </a>
                            </div>
        
                            <div class="col-4">
                                <a href="" class="header__responsive-bar-item">
                                    <div class="header__responsive-bar-icon">
                                        <i class="fa-solid fa-ranking-star"></i>
                                    </div>
                                    <div class="header__responsive-bar-text">
                                        X???p H???ng                                
                                    </div>
                                </a>
                            </div>
        
                            <div class="col-4">
                                <a href="" class="header__responsive-bar-item">
                                    <div class="header__responsive-bar-icon">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </div>
                                    <div class="header__responsive-bar-text">
                                        ????ng Truy???n
                                    </div>
                                </a>
                            </div>
    
                        </div>
                    </div>
                </header>
            </div>
        </div>

        <div class="content">
            <!-- ===== banner ====== -->
            <div class="banner d-none d-md-block">
                <div class="banner__img"></div>
            </div>

            <div class="container-fluid p-0">
                <div class="container block-content">
                    <?php include $VIEW_NAME ?>
                </div>
                <footer class="footer">
                    <div class="row">
                        <div class="col-12">
                            <a href="index.html" class="footer__logo logo">
                                <img src="https://metruyenchu.com/assets/images/logo.png?260329" alt="">
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="footer__introduce limit3">
                                M?? Truy???n Ch??? l?? n???n t???ng m??? tr???c tuy???n, mi???n ph?? ?????c truy???n ch??? ???????c convert ho???c d???ch k??? l?????ng, do c??c converter v?? d???ch gi??? ????ng g??p, r???t nhi???u truy???n hay v?? n???i b???t ???????c c???p nh???t nhanh nh???t v???i ????? c??c th??? lo???i ti??n hi???p, ki???m hi???p, huy???n ???o ,...
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="" class="footer__btn">
                                <img src="https://metruyenchu.com/assets/images/app-store.png?260329" alt="">
                            </a>
                            <a href="" class="footer__btn">
                                <img src="https://metruyenchu.com/assets/images/google-play.png?260329" alt="">
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="footer__link link ">??i???u Kho???n D???ch V???</div>
                            <div class="footer__link link">Ch??nh S??ch B???o M???t</div>
                            <div class="footer__link link">V??? B???n Quy???n</div>
                            <div class="footer__link link">H?????ng D???n S??? D???ng</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- ====Chat===== -->
        <div class="admin-chat" title="?????t c??u h???i cho Admin">
            <form method="post" class="admin-held">
                <div class="admin-held-input">
                    <div>Username</div>
                    <input type="text" value="Ng???c ?????c" placeholder="Username">
                </div>
                <div class="admin-held-input">
                    <div>Email</div>
                    <input type="email" value="zerotwo13102001@gmail.com" placeholder="Email">
                </div>
                <div class="admin-held-input">
                    <div>C??u h???i</div>
                    <textarea name="" id="" cols="30" rows="3" placeholder="C??u h???i"></textarea>
                </div>
                <input type="submit" value="G???i ??i" class="admin-chat-submit">
            </form>
            <div class="admin-chat-icon">
                <div class="admin-chat-icon-item"><i class="fas fa-comment"></i></div>
                <div class="admin-chat-icon-item"><i class="fas fa-times"></i></div>
            </div>
        </div>

        <!-- ===modifier==== -->
        <div class="modifier modifier-err">
            <div class="modifier-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="modifier-text">
                <div class="modifier-title">Th???c hi???n thao t??c kh??ng th??nh c??ng</div>
                <div class="modifier-content">B???n c???n ????ng nh???p ????? th???c hi???n ch???c n??ng n??y</div>
            </div>
        </div>
        <div class="modifier modifier-success">
            <div class="modifier-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="modifier-text">
                <div class="modifier-title">????ng nh???p th??nh c??ng</div>
                <div class="modifier-content">Ch??o ?????c, Ch??c b???n ?????c truy???n vui v???!</div>
            </div>
        </div>

        <!-- === nhi???m v??? event: tet,moon,noel ==== -->
        <a href="" class="event active">
            <div class="event__content">
                <i class="fad fa-moon-stars"></i>
                <i class="fas fa-stocking"></i>
                <i class="far fa-piggy-bank"></i>
            </div>
        </a>

        <!-- =======modal====== -->
        <div class="modal">
            <div class="modal__overlay"></div>
            <div class="modal__content">
                <div class="modal__form modal__form-login">
                    <div class="modal__form-header">
                        <div class="modal__form-header-text active" id="modal__form-login">????ng Nh???p</div>
                        <div class="modal__form-header-text" id="modal__form-register">????ng K??</div>
                    </div>
                    <div class="modal__form-content">
                        <form method="post" id="formLogin" class="modal__form-content-main">
                            <input type="text" name="link" value="<?=$link?>" hidden>
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span style="color: var(--text)">Email</span>
                                </div>
                                <input type="email" placeholder="Nh???p Email" name="login__email">
                                <span class="modal__form-err"></span>
                            </div>
                            <div class="modal__form-input form-err">
                                <div class="modal__form-input-text">
                                    <span>Password</span>
                                    <span class="modal__form-forgotPassBtn">Qu??n M???t Kh???u?</span>
                                </div>
                                <input type="password" placeholder="Nh???p M???t Kh???u" name="login__pass">
                                <span class="modal__form-err"></span>
                            </div>

                            <div class="modal__form-checkbox">
                                <input type="checkbox" id="modal__form-checkbox" hidden>
                                <label for="modal__form-checkbox" class="modal__form-checkbox">
                                    <div class="modal__form-checkbox-block">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="modal__form-checkbox-text">Nh??? M???t Kh???u?</div>
                                </label>
                            </div>

                            <input type="submit" name="submitLogin" value="????ng Nh???p" class="modal__form-submit">
                        </form>
                    </div>
                    <div class="modal__form-footer">
                        <div class="modal__form-footer-text">B???n ch??a c?? t??i kho???n?</div>
                        <label for="modal__form-register">????ng K?? Ngay</label>
                    </div>
                </div>
                <div class="modal__form modal__form-register">
                    <div class="modal__form-header">
                        <div class="modal__form-header-text active" id="modal__form-register">????ng K??</div>
                        <div class="modal__form-header-text" id="modal__form-login">????ng Nh???p</div>
                    </div>
                    <div class="modal__form-content">
                        <form method="POST" id="formRegister" action="<?=$DAO_URL?>/sign_up_login/register.php" class="modal__form-content-main">
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Email</span>
                                </div>
                                <input type="email" name="registerEmail" placeholder="Nh???p Email">
                                <span class="modal__form-err"></span>
                            </div>
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Username</span>
                                </div>
                                <input type="text" name="registerUsername" placeholder="Nh???p username">
                                <span class="modal__form-err"></span>
                            </div>
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Password</span>
                                </div>
                                <input type="text" name="registerPass" placeholder="Nh???p M???t Kh???u">
                                <span class="modal__form-err"></span>
                            </div>

                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Nh???p L???i Password</span>
                                </div>
                                <input type="text" name="registerPassConfirmed" placeholder="Nh???p M???t Kh???u">
                                <span class="modal__form-err"></span>
                            </div>
                            <input type="text" name="link" hidden value="<?=$link?>">

                            <input type="submit" value="????ng K??" name="registerSubmit" class="modal__form-submit">
                        </form>
                    </div>
                    <div class="modal__form-footer">
                        <div class="modal__form-footer-text">B???n ???? c?? t??i kho???n?</div>
                        <label for="modal__form-login">????ng Nh??p ??? ????y</label>
                    </div>
                </div>
                <div class="modal__form modal__form-forgotPass">
                    <div class="modal__form-header">
                        <div class="modal__form-header-text">Qu??n M???t Kh???u</div>
                    </div>
                    <div class="modal__form-content">
                        <form action="<?=$DAO_URL?>/phpMailler/forget_pass.php" method="post" id="forgotPass" class="modal__form-content-main">
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span style="color: var(--text)">Email</span>
                                </div>
                                <input type="email" name="forgotPass-email" placeholder="Nh???p Email">
                                <span class="modal__form-err"></span>
                            </div>
                            <input type="submit" value="L???y M???t Kh???u" class="modal__form-submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!isset($_SESSION['user'])) :?>
    <script src="<?=$CONTENT_URL?>/JS/login.js"></script>
    <?php endif?>
    <script src="<?=$CONTENT_URL?>/JS/public.js"></script>
    <script src="<?=$CONTENT_URL?>/JS/validation.js"></script>

    <?php 
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            $mess = $_GET['message'];
            if ($status == 1) { 
    ?>
            <script>    
                if(typeof window.history.pushState == 'function') {
                    window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
                }
                showModifier('.modifier.modifier-success',<?=$mess?>,'');
                </script>
    <?php
            }elseif ($status == 0) {    
    ?>

            <script>    
                if(typeof window.history.pushState == 'function') {
                    window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
                }
                showModifier('.modifier.modifier-err',<?=$mess?>,'');
            </script>

    <?php 
            }
        }
    ?>

    <!-- validate form  -->
    <script>
        validator({
            form: '#formLogin',
            errSelector: '.modal__form-err',
            rules: [
                validator.isRequied('input[name="login__email"]','Tr?????ng email kh??ng ???????c b??? tr???ng'),
                validator.isEmail('input[name="login__email"]','B???n ch??a nh???p ????ng ?????nh d???ng email'),
                validator.isRequied('input[name="login__pass"]','Tr?????ng m???t kh???u kh??ng ???????c b??? tr???ng'),
                validator.minLength('input[name="login__pass"]',5,'M???t kh???u d??i t???i thi???u 5 k?? t???'),
            ]
        });

        validator({
            form: '#formRegister',
            errSelector: '.modal__form-err',
            rules: [
                validator.isRequied('input[name="registerEmail"]','Tr?????ng email kh??ng ???????c b??? tr???ng'),
                validator.isEmail('input[name="registerEmail"]','B???n ch??a nh???p ????ng ?????nh d???ng email'),
                validator.isRequied('input[name="registerPass"]','Tr?????ng m???t kh???u kh??ng ???????c b??? tr???ng'),
                validator.isRequied('input[name="registerUsername"]','Kh??ng ???????c b??? tr???ng Username'),
                validator.minLength('input[name="registerUsername"]',5,'Username d??i t???i thi???u 5 k?? t???'),
                validator.minLength('input[name="registerPass"]',5,'M???t kh???u d??i t???i thi???u 5 k?? t???'),
                validator.isRequied('input[name="registerPassConfirmed"]','Tr?????ng n??y kh??ng ???????c b??? tr???ng'),
                validator.confirmed('input[name="registerPassConfirmed"]',function () {
                return document.querySelector('#formRegister input[name="registerPass"]').value;
                },'M???t kh???u nh???p l???i kh??ng ch??nh x??c'),
            ]
        });
        validator({
            form: '#forgotPass',
            errSelector: '.modal__form-err',
            rules: [
                validator.isRequied('input[name="forgotPass-email"]','Tr?????ng email kh??ng ???????c b??? tr???ng'),
                validator.isEmail('input[name="forgotPass-email"]','B???n ch??a nh???p ????ng ?????nh d???ng email'),
            ]
        });
    </script>
    <script>
        nextPage('.header__search-input','.header__search-history');
        const newArr = phpArrayJs(<?=json_encode($truyen)?>);
        search(newArr,'.header__search-input','.header__search-history','<?=$USER_URL.'/truyen/index.php?idTruyen='?>');
    </script>
</body>
</html>