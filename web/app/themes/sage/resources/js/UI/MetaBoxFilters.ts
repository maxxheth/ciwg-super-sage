// Write a fat-arrow function that accesses the URL param `post` and filters it against the number 11. If it doesn't match, return false. This must be written in vanilla JS / TS.

const filterByPostId = () => {
  const urlParams = new URLSearchParams(window.location.search);
  const postId = urlParams.get('post');

  if (postId && parseInt(postId, 10) === 11) {
    return true;
  }

  return false;
};

export const hideServicesPageMetaBox = (selector: string) => {
  const metaBox = document.querySelector(selector) as HTMLElement;
  if (!filterByPostId() && metaBox) {
    metaBox.style.display = 'none';
  }
};
