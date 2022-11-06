<main class="devwebcamp">
    <h2 class="devwebcamp__heading">
        <?php echo $titulo; ?>
    </h2>

    <p class="devwebcamp__descripcion">Conoce la conferencia más importante de Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div data-aos="<?php aos_animacion(); ?>" class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/sobre_devwebcamp.jpg" alt="imagen devwebcamp">
            </picture>
        </div>

        <div data-aos="<?php aos_animacion(); ?>" class="devwebcamp__contenido">
            <p class="devwebcamp__texto">Amet consectetur adipisicing elit. Quam aperiam consectetur dicta cupiditate nam. Sapiente ipsum eum possimus maiores alias optio, modi, accusantium impedit ratione, provident necessitatibus quidem accusamus veritatis.</p>
            <p class="devwebcamp__texto">Amet consectetur adipisicing elit. Quam aperiam consectetur dicta cupiditate nam. Sapiente ipsum eum possimus maiores alias optio, modi, accusantium impedit ratione, provident necessitatibus quidem accusamus veritatis.</p>
        </div>
    </div>

</main>