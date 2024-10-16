jQuery(document).ready(function () {
  jQuery(".your-class").slick({
    // autoplay: true,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: "linear",
    adaptiveHeight: true,
    dots: wpslider_object_inject.dots === "1",
    responsive: [
      {
        breakpoint: 1023,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
});
