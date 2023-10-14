document.addEventListener("DOMContentLoaded", function () {
  const NEW_FEATURE_KEY = "003";

  if ($(`#new-feature-${NEW_FEATURE_KEY}`).length) {
    const newFeatureModal = new bootstrap.Modal(
      $(`#new-feature-${NEW_FEATURE_KEY}`)[0]
    );
    const dontShowAgainFeatureBtn = $(".dont-show-again-feature-btn");

    const LAST_FEATURE_KEY_LS = "daily-sphere-last-feature-key";
    const LAST_FEATURE_SHOWN_DATE_LS = "daily-sphere-last-feature-shown-date";
    const LAST_FEATURE_NOT_SHOW_LS = "daily-sphere-last-feature-not-show";

    const lastFeatureKey = localStorage.getItem(LAST_FEATURE_KEY_LS) || "000";
    const lastFeatureShownDate =
      localStorage.getItem(LAST_FEATURE_SHOWN_DATE_LS) ||
      new Date(Date.now() - 86400000).toISOString().split("T")[0];
    const lastFeatureNotShow =
      Boolean(localStorage.getItem(LAST_FEATURE_NOT_SHOW_LS)) || false;

    const todaysDate = new Date().toISOString().split("T")[0];

    if (
      lastFeatureKey != NEW_FEATURE_KEY ||
      (lastFeatureShownDate != todaysDate && !lastFeatureNotShow)
    ) {
      newFeatureModal.show();

      localStorage.setItem(LAST_FEATURE_KEY_LS, NEW_FEATURE_KEY);
      localStorage.setItem(LAST_FEATURE_SHOWN_DATE_LS, todaysDate);
    }

    dontShowAgainFeatureBtn.on("click", (e) => {
      localStorage.setItem(LAST_FEATURE_NOT_SHOW_LS, true);
    });
  }
});
