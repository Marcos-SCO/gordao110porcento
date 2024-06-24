const preventPassiveWarning = event => {
  if (!jQuery) return;

  jQuery.event.special[event] = {
    setup: function (_, ns, handle) {
      if (ns.includes("noPreventDefault")) {
        this.addEventListener(event, handle, { passive: false });
      } else {
        this.addEventListener(event, handle, { passive: true });
      }
    }
  }
}

export { preventPassiveWarning };