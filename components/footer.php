        </main>

        <footer>
            GameList - Tous droits réservés <?php echo date('d/m/Y H:i') ?>
        </footer>

        <div class="notifications">
            <?php foreach (getAllFlashes() as $flash){ ?>
                <div class="notification notification-<?php echo $flash['type']; ?>">
                    <?php echo $flash['content']; ?>
                </div>
            <?php } ?>
        </div>
    </body>
</html>