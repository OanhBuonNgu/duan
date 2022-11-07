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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?=CONTENT_URL?>plugins/summernote/summernote-bs4.min.css">
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
                                <span>Thể Loại</span>
                            </div>
    
                            <div class="header__category-content category">
                                <div class="category-item">
                                    <a href="<?=$USER_URL?>/loctruyen/index.php" class="category-item-link">Tất Cả</a>
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
                            <div class="header__rank-text">Bảng Xếp Hạng</div>
                        </a>
                    </div>
                    <!-- ===========search========= -->
                    <div class="header__search">
                        <form class="header__search-input">
                            <input type="text" name="header__search-input" autocomplete="off" placeholder="Nhập tên truyện hoặc tác giả">
                            <i class="fas fa-search header__search-icon"></i>

                            <!-- === history === -->
                            <div class="category header__search-history"></div>
                        </form>
                        
                    </div>
    
                    <div class="header__right">
                        <a href="<?=$ADMIN_URL?>/truyen/indexAdminTruyen.php" class="header__upload">
                            <div class="block-icon">
                                <i class="fas fa-upload"></i>
                                <span>Đăng Truyện</span>
                            </div>
                        </a>
        
                        <?php if (!isset($_SESSION['user'])) :?>
                        <!-- ========đăng nhập,đăng kí=========== -->
                        <div class="header__login header__form">Đăng Nhập</div>
                        <div class="header__register header__form">Đăng Ký</div>
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
                                        <span>Bạn chưa có thông báo nào!</span>
                                    </li>
                                <?php endif?>
                                <a href="<?=$USER_URL?>/usermanager/index.php?idUser=<?=$_SESSION['user']['idUser']?>" class="header__notify-content-footer">
                                    <span>Xem tất cả</span>
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
                                    <a href="<?=$USER_URL?>/usermanager/index.php?idUser=1" class="category-item-link">Hồ Sơ</a>
                                </div>
                                <div class="category-item">
                                    <a href="" class="category-item-link">Tủ Truyện</a>
                                </div>
                                <div class="category-item">
                                    <a href="" class="category-item-link">Cài Đặt</a>
                                </div>
                                <div class="category-item">
                                    <a href="" class="category-item-link">Nhận Thưởng</a>
                                </div>
                                <div class="category-item">
                                    <a href="<?=$DAO_URL?>/sign_up_login/logout.php?link=<?=$link?>" class="category-item-link">Đăng Xuất</a>
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
                                <input type="text" placeholder="Tìm kiếm tên truyện hoặc tên tác giả">
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
                            <div class="header__responsive-nav-item-text header__login">Đăng Nhập</div>
                        </div>
                        <div class="header__responsive-nav-item">
                            <div class="header__responsive-nav-item-text header__register">Đăng Ký</div>
                        </div>
                        <div class="header__responsive-nav-item">
                            <div class="header__responsive-nav-item-icon">
                                <i class="fa-solid fa-ranking-star"></i>
                            </div>
                            <label for="check__nav-rank-child" class="mb-0 header__responsive-nav-item-text">Bảng Xếp Hạng</label>
                            <div class="header__responsive-nav-item-icon ml-auto">
                                <i class="fa-solid fa-angle-down"></i>
                            </div>
                        </div>
    
                        <div class="header__responsive-nav-item-child check__nav-rank-child">
                            <div class="header__responsive-nav-item-child-text">Đọc Nhiều</div>
                            <div class="header__responsive-nav-item-child-text">Tặng Thưởng</div>
                            <div class="header__responsive-nav-item-child-text">Đề Cử</div>
                            <div class="header__responsive-nav-item-child-text">Yêu Thích</div>
                            <div class="header__responsive-nav-item-child-text">Thảo Luận</div>
                        </div>
                        <div class="header__responsive-nav-item">
                            <div class="header__responsive-nav-item-icon">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </div>
                            <label for="check__nav-category-child" class=" mb-0 header__responsive-nav-item-text">Thể Loại</label>
                            <div class="header__responsive-nav-item-icon ml-auto">
                                <i class="fa-solid fa-angle-down"></i>
                            </div>
                        </div>
                        <div class="header__responsive-nav-item-child check__nav-category-child">
                            <a href="HTML/category.html" class="header__responsive-nav-item-child-text">Tất Cả</a>
                            <div class="header__responsive-nav-item-child-text">Huyền Huyễn</div>
                            <div class="header__responsive-nav-item-child-text">Tiên Hiệp</div>
                            <div class="header__responsive-nav-item-child-text">Võng Du</div>
                            <div class="header__responsive-nav-item-child-text">Cạnh Kỹ</div>
                            <div class="header__responsive-nav-item-child-text">Đồng Nhân</div>
                            <div class="header__responsive-nav-item-child-text">Trinh Thám</div>
                            <div class="header__responsive-nav-item-child-text">Đời Thường</div>
                            <div class="header__responsive-nav-item-child-text">Trọng Sinh</div>
                            <div class="header__responsive-nav-item-child-text">Mạt Thế</div>
                            <div class="header__responsive-nav-item-child-text">Huyền Nghi</div>
                            <div class="header__responsive-nav-item-child-text">Kỳ Ảo</div>
                        </div>
                    </div>
    
                    <div class="header__responsive-bar">
                        <div class="row w-100" style="padding: 0 15px;">
                            <div class="col-4">
                                <a href="" class="header__responsive-bar-item">
                                    <div class="header__responsive-bar-icon">
                                        <i class="fa-solid fa-table-cells-large"></i>
                                    </div>
                                    <div class="header__responsive-bar-text">Danh Sách</div>
                                </a>
                            </div>
        
                            <div class="col-4">
                                <a href="" class="header__responsive-bar-item">
                                    <div class="header__responsive-bar-icon">
                                        <i class="fa-solid fa-ranking-star"></i>
                                    </div>
                                    <div class="header__responsive-bar-text">
                                        Xếp Hạng                                
                                    </div>
                                </a>
                            </div>
        
                            <div class="col-4">
                                <a href="" class="header__responsive-bar-item">
                                    <div class="header__responsive-bar-icon">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </div>
                                    <div class="header__responsive-bar-text">
                                        Đăng Truyện
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
                                Mê Truyện Chữ là nền tảng mở trực tuyến, miễn phí đọc truyện chữ được convert hoặc dịch kỹ lưỡng, do các converter và dịch giả đóng góp, rất nhiều truyện hay và nổi bật được cập nhật nhanh nhất với đủ các thể loại tiên hiệp, kiếm hiệp, huyền ảo ,...
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
                            <div class="footer__link link ">Điều Khoản Dịch Vụ</div>
                            <div class="footer__link link">Chính Sách Bảo Mật</div>
                            <div class="footer__link link">Về Bản Quyền</div>
                            <div class="footer__link link">Hướng Dẫn Sử Dụng</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- ====Chat===== -->
        <div class="admin-chat" title="Đặt câu hỏi cho Admin">
            <form method="post" class="admin-held">
                <div class="admin-held-input">
                    <div>Username</div>
                    <input type="text" value="Ngọc Đức" placeholder="Username">
                </div>
                <div class="admin-held-input">
                    <div>Email</div>
                    <input type="email" value="zerotwo13102001@gmail.com" placeholder="Email">
                </div>
                <div class="admin-held-input">
                    <div>Câu hỏi</div>
                    <textarea name="" id="" cols="30" rows="3" placeholder="Câu hỏi"></textarea>
                </div>
                <input type="submit" value="Gửi đi" class="admin-chat-submit">
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
                <div class="modifier-title">Thực hiện thao tác không thành công</div>
                <div class="modifier-content">Bạn cần đăng nhập để thực hiện chức năng này</div>
            </div>
        </div>
        <div class="modifier modifier-success">
            <div class="modifier-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="modifier-text">
                <div class="modifier-title">Đăng nhập thành công</div>
                <div class="modifier-content">Chào Đức, Chúc bạn đọc truyện vui vẻ!</div>
            </div>
        </div>

        <!-- === nhiệm vụ event: tet,moon,noel ==== -->
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
                        <div class="modal__form-header-text active" id="modal__form-login">Đăng Nhập</div>
                        <div class="modal__form-header-text" id="modal__form-register">Đăng Ký</div>
                    </div>
                    <div class="modal__form-content">
                        <form method="post" id="formLogin" class="modal__form-content-main">
                            <input type="text" name="link" value="<?=$link?>" hidden>
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span style="color: var(--text)">Email</span>
                                </div>
                                <input type="email" placeholder="Nhập Email" name="login__email">
                                <span class="modal__form-err"></span>
                            </div>
                            <div class="modal__form-input form-err">
                                <div class="modal__form-input-text">
                                    <span>Password</span>
                                    <span class="modal__form-forgotPassBtn">Quên Mật Khẩu?</span>
                                </div>
                                <input type="password" placeholder="Nhập Mật Khẩu" name="login__pass">
                                <span class="modal__form-err"></span>
                            </div>

                            <div class="modal__form-checkbox">
                                <input type="checkbox" id="modal__form-checkbox" hidden>
                                <label for="modal__form-checkbox" class="modal__form-checkbox">
                                    <div class="modal__form-checkbox-block">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="modal__form-checkbox-text">Nhớ Mật Khẩu?</div>
                                </label>
                            </div>

                            <input type="submit" name="submitLogin" value="Đăng Nhập" class="modal__form-submit">
                        </form>
                    </div>
                    <div class="modal__form-footer">
                        <div class="modal__form-footer-text">Bạn chưa có tài khoản?</div>
                        <label for="modal__form-register">Đăng Ký Ngay</label>
                    </div>
                </div>
                <div class="modal__form modal__form-register">
                    <div class="modal__form-header">
                        <div class="modal__form-header-text active" id="modal__form-register">Đăng Ký</div>
                        <div class="modal__form-header-text" id="modal__form-login">Đăng Nhập</div>
                    </div>
                    <div class="modal__form-content">
                        <form method="POST" id="formRegister" action="<?=$DAO_URL?>/sign_up_login/register.php" class="modal__form-content-main">
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Email</span>
                                </div>
                                <input type="email" name="registerEmail" placeholder="Nhập Email">
                                <span class="modal__form-err"></span>
                            </div>
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Username</span>
                                </div>
                                <input type="text" name="registerUsername" placeholder="Nhập username">
                                <span class="modal__form-err"></span>
                            </div>
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Password</span>
                                </div>
                                <input type="text" name="registerPass" placeholder="Nhập Mật Khẩu">
                                <span class="modal__form-err"></span>
                            </div>

                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span>Nhập Lại Password</span>
                                </div>
                                <input type="text" name="registerPassConfirmed" placeholder="Nhập Mật Khẩu">
                                <span class="modal__form-err"></span>
                            </div>
                            <input type="text" name="link" hidden value="<?=$link?>">

                            <input type="submit" value="Đăng Ký" name="registerSubmit" class="modal__form-submit">
                        </form>
                    </div>
                    <div class="modal__form-footer">
                        <div class="modal__form-footer-text">Bạn đã có tài khoản?</div>
                        <label for="modal__form-login">Đăng Nhâp Ở Đây</label>
                    </div>
                </div>
                <div class="modal__form modal__form-forgotPass">
                    <div class="modal__form-header">
                        <div class="modal__form-header-text">Quên Mật Khẩu</div>
                    </div>
                    <div class="modal__form-content">
                        <form action="<?=$DAO_URL?>/phpMailler/forget_pass.php" method="post" id="forgotPass" class="modal__form-content-main">
                            <div class="modal__form-input">
                                <div class="modal__form-input-text">
                                    <span style="color: var(--text)">Email</span>
                                </div>
                                <input type="email" name="forgotPass-email" placeholder="Nhập Email">
                                <span class="modal__form-err"></span>
                            </div>
                            <input type="submit" value="Lấy Mật Khẩu" class="modal__form-submit">
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
                validator.isRequied('input[name="login__email"]','Trường email không được bỏ trống'),
                validator.isEmail('input[name="login__email"]','Bạn chưa nhập đúng định dạng email'),
                validator.isRequied('input[name="login__pass"]','Trường mật khẩu không được bỏ trống'),
                validator.minLength('input[name="login__pass"]',5,'Mật khẩu dài tối thiểu 5 ký tự'),
            ]
        });

        validator({
            form: '#formRegister',
            errSelector: '.modal__form-err',
            rules: [
                validator.isRequied('input[name="registerEmail"]','Trường email không được bỏ trống'),
                validator.isEmail('input[name="registerEmail"]','Bạn chưa nhập đúng định dạng email'),
                validator.isRequied('input[name="registerPass"]','Trường mật khẩu không được bỏ trống'),
                validator.isRequied('input[name="registerUsername"]','Không được bỏ trống Username'),
                validator.minLength('input[name="registerUsername"]',5,'Username dài tối thiểu 5 ký tự'),
                validator.minLength('input[name="registerPass"]',5,'Mật khẩu dài tối thiểu 5 ký tự'),
                validator.isRequied('input[name="registerPassConfirmed"]','Trường này không được bỏ trống'),
                validator.confirmed('input[name="registerPassConfirmed"]',function () {
                return document.querySelector('#formRegister input[name="registerPass"]').value;
                },'Mật khẩu nhập lại không chính xác'),
            ]
        });
        validator({
            form: '#forgotPass',
            errSelector: '.modal__form-err',
            rules: [
                validator.isRequied('input[name="forgotPass-email"]','Trường email không được bỏ trống'),
                validator.isEmail('input[name="forgotPass-email"]','Bạn chưa nhập đúng định dạng email'),
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