// Image gallery: shows one image at a time. Each arrow click moves exactly one image.
// Works on every element that has the data-gallery attribute.
document.querySelectorAll('[data-gallery]').forEach(function (gallery) {
  const track = gallery.querySelector('.gallery-track');
  const prev = gallery.querySelector('.gallery-prev');
  const next = gallery.querySelector('.gallery-next');
  const count = gallery.querySelector('.gallery-count');

  // A post with one image has no arrows, so there is nothing to do
  if (!track || !prev || !next) {
    return;
  }

  const total = track.children.length;

  function currentIndex() {
    return Math.round(track.scrollLeft / track.clientWidth);
  }

  function update() {
    const index = currentIndex();
    prev.hidden = index <= 0;           // no "previous" on the first image
    next.hidden = index >= total - 1;   // no "next" on the last image
    count.textContent = (index + 1) + ' / ' + total;
  }

  function move(direction) {
    track.scrollBy({ left: direction * track.clientWidth });
  }

  prev.addEventListener('click', function () { move(-1); });
  next.addEventListener('click', function () { move(1); });
  track.addEventListener('scroll', update);
  window.addEventListener('resize', update);

  // Left and right arrow keys work when the gallery has focus
  track.addEventListener('keydown', function (event) {
    if (event.key === 'ArrowRight') { event.preventDefault(); move(1); }
    if (event.key === 'ArrowLeft') { event.preventDefault(); move(-1); }
  });

  update();
});
