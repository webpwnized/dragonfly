
class BrowserDataStorage {
    constructor() {}

    // Store data in cookies
    putInCookie(data) {
        try {
            document.cookie = `userData=${JSON.stringify(data)}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
        } catch (error) {
            console.error('Error storing data in cookies:', error);
        }
    }

    // Fetch data from cookies
    getFromCookie() {
        try {
            const cookieData = document.cookie
                .split(';')
                .map(cookie => cookie.split('='))
                .find(([key]) => key.trim() === 'userData');

            if (cookieData) {
                return JSON.parse(cookieData[1]);
            }
        } catch (error) {
            console.error('Error fetching data from cookies:', error);
        }
        return null;
    }

    // Store data in local storage
    putInLocalStorage(data) {
        try {
            localStorage.setItem('userData', JSON.stringify(data));
        } catch (error) {
            console.error('Error storing data in local storage:', error);
        }
    }

    // Fetch data from local storage
    getFromLocalStorage() {
        try {
            const localStorageData = localStorage.getItem('userData');
            if (localStorageData) {
                return JSON.parse(localStorageData);
            }
        } catch (error) {
            console.error('Error fetching data from local storage:', error);
        }
        return null;
    }

    // Store data in session storage
    putInSessionStorage(data) {
        try {
            sessionStorage.setItem('userData', JSON.stringify(data));
        } catch (error) {
            console.error('Error storing data in session storage:', error);
        }
    }

    // Fetch data from session storage
    getFromSessionStorage() {
        try {
            const sessionStorageData = sessionStorage.getItem('userData');
            if (sessionStorageData) {
                return JSON.parse(sessionStorageData);
            }
        } catch (error) {
            console.error('Error fetching data from session storage:', error);
        }
        return null;
    }

    // Store data in IndexedDB
    putInIndexedDB(data) {
        try {
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
        } catch (error) {
            console.error('Error storing data in IndexedDB:', error);
        }
    }

    // Fetch data from IndexedDB
    async getFromIndexedDB() {
        try {
            const request = indexedDB.open('userDataDB', 1);

            request.onerror = function(event) {
                console.error('IndexedDB error:', event.target.errorCode);
            };

            const db = await new Promise((resolve, reject) => {
                request.onsuccess = function(event) {
                    resolve(event.target.result);
                };
                request.onupgradeneeded = function(event) {
                    const db = event.target.result;
                    db.createObjectStore('userData');
                    resolve(db);
                };
            });

            const transaction = db.transaction(['userData'], 'readonly');
            const objectStore = transaction.objectStore('userData');
            const getRequest = objectStore.get(1);

            getRequest.onerror = function(event) {
                console.error('IndexedDB get error:', event.target.errorCode);
            };

            return await new Promise((resolve, reject) => {
                getRequest.onsuccess = function(event) {
                    resolve(event.target.result);
                };
            });
        } catch (error) {
            console.error('Error fetching data from IndexedDB:', error);
            return null;
        }
    }
}
