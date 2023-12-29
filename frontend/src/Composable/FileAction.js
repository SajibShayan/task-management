export const useDestroyFile = async (event) => {
    const file_path = event.response?.body?.data;
    if (!file_path) return;

    return window.axios
        .delete(route("files:destroy"), {   //TODO: need to fixed delete api
            data: { file_path },
        })
        .then((res) => res)
        .catch((e) => {});
};

export const getFilePath = (response) => {
    
    if(!response) return;
    
    let path = "";
    response?.["s3Multipart"]
        ? (path = response["s3Multipart"]?.key)
        : (path = `temps/${response?.name}`);

    return path;
};
