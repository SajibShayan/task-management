export const useParentPathName = (path) => {
    const segments = path.split("/");
    return segments[1];
};