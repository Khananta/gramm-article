<div class="container">
    <div class="row mt-4">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="text-start col-lg-8 offset-lg-2">
            <div class="input-group">
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                ?>
                <input type="text" name="search" class="form-control" placeholder="Temukan berbagai artikel menarik.."
                    value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
</div>