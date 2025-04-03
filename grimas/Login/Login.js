(function () {

  // Edge lacks:
  // * TextEncoder for UTF-8 bytes to use strings in crypto
  // * crypto.subtle.digest("SHA-1") to query well known passwords
  // * crypto.subtle.deriveBits("PBKDF2") to hide human password from server

  if (document.readyState == "complete") {
    setup();
  } else {
    document.addEventListener("DOMContentLoaded", setup);
  }

  function initializeInstitutionFields() {
    document.querySelectorAll('select[name="institution"], input[name="institution"]').forEach(institutionElt => {
      institutionElt.addEventListener('change', function () {
        const usernameElt = this.form.elements.namedItem("username");
        if (usernameElt) {
          usernameElt.value = this.value;
          usernameElt.dispatchEvent(new Event('change'));
        }
        const passwordElt = this.form.elements.namedItem("password");
        if (passwordElt) {
          passwordElt.value = this.value;
          passwordElt.dispatchEvent(new Event('change'));
        }
      });
    });
  }

  function setup() {
    // Setup for password fields
    document.querySelectorAll('input[name="password"]').forEach(elt => {
      elt.addEventListener('input', function (event) {
        const input = event.target;
        if (input.dataset.invalid === "true") {
          delete input.dataset.invalid;
        }
      });
      elt.form.addEventListener("submit", onSubmit);
      elt.addEventListener("input", onInput );
    });

    initializeInstitutionFields();
  }

  function onSubmit(event) {
    const form = event.target;
    if (form instanceof HTMLFormElement) {
      const passwordElt = form.elements.namedItem("password");
      const usernameElt = form.elements.namedItem("username");
      const institutionElt = form.elements.namedItem("institution");
      if ((passwordElt && passwordElt.value)
        && (!passwordElt.value.startsWith("PBKDF2-"))
      ) {
        event.preventDefault();
        const username = usernameElt ? usernameElt.value : "user";
        const institution = institutionElt ? institutionElt.value : "institution";
        const password = passwordElt.value;
        const checkPromise = Promise.resolve(passwordElt);
        const hashPromise = hash(password, `grima-clientside-login-v1:${institution}:${username}`)
        Promise.all([checkPromise, hashPromise])
          .then(([_, hash]) => {
            passwordElt.value = hash;
            // Ensure username is set to institution value
            usernameElt.value = institutionElt ? institutionElt.value : username;
            form.submit();
          })
          .catch(error => {
            console.error("Error during hashing:", error);
          });
      }
    }
  }

  function onInput(event) {
    const input = event.target;
    if (input.dataset.invalid === "true") {
      delete input.dataset.invalid;
    }
  }

  function hash(password, salt_seed) {
    const name = "PBKDF2";
    const hash = "SHA-512";
    const iterations = 1000000; // 0.7 seconds on my 2013 laptop
    if (!(window.crypto && window.crypto.subtle)) {
      if (window.location.protocol === "http:") {
        return Promise.reject("Client side crypto not available. Ask your server admin to use https.");
      } else {
        return Promise.reject("Client side crypto not available. Please use a supported browser.");
      }
    }
    return window.crypto.subtle
      .digest(hash, bin(salt_seed))
      .then(salt => window.crypto.subtle
        .importKey("raw", bin(password), { name }, false, ["deriveBits"])
        .then((pw) => window.crypto.subtle
          .deriveBits({ name, salt, iterations, hash }, pw, 128))
        .then((key) => `PBKDF2-${hash}\$${iterations}\$${hex(salt)}\$${hex(key)}`))
      .catch((err) => {
        if (err.name === "PBKDF2") {
          return Promise.reject("Client side crypto not available. Please don't use Edge.");
        } else {
          throw err;
        }
      });
  }

  function bin(str) {
    return new TextEncoder("utf-8").encode(str);
  }

  function hex(bin) {
    return Array.prototype.slice
      .call(new Uint8Array(bin))
      .map(x => [x >> 4, x & 15])
      .map(ab => ab.map(x => x.toString(16)).join(""))
      .join("");
  }

})();
