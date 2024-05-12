class BrowserDataStorage {
    constructor() {}

    // Store data in cookies
    storeInCookie(data) {
        document.cookie = `userData=${JSON.stringify(data)}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
    }

    // Store data in local storage
    storeInLocalStorage(data) {
        localStorage.setItem('userData', JSON.stringify(data));
    }

    // Store data in session storage
    storeInSessionStorage(data) {
        sessionStorage.setItem('userData', JSON.stringify(data));
    }

    // Store data in IndexedDB
    storeInIndexedDB(data) {
        const request = indexedDB.open('userDataDB', 1);

        request.onerror = function(event) {
            console.error('IndexedDB error:', event.target.errorCode);
        };

        request.onsuccess = function(event) {
            const db = event.target.result;
            const transaction = db.transaction(['userData'], 'readwrite');
            const objectStore = transaction.objectStore('userData');
            const putRequest = objectStore.put(data, 1);

            putRequest.onerror = function(event) {
                console.error('IndexedDB put error:', event.target.errorCode);
            };
        };
    }
}

