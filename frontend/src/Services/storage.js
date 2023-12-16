function getItem(key) {
    const value = localStorage.getItem(key)
        ;
    try {
        const parsedValue = JSON.parse(value)
        return parsedValue;
    } catch (e) {
        return value;
    }
}

function setItem(key, value) {

    if (typeof value === "string") {
        localStorage.setItem(key, value)
        return;
    }
    localStorage.setItem(key, JSON.stringify(value));

    return;
}

function clearItem(key = null) {
    if (key) {
        localStorage.removeItem(key);
        return;
    }
    localStorage.clear()
    return;
}

export default { setItem, getItem, clearItem }