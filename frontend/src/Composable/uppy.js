import Uppy from "@uppy/core";
import AwsS3 from "@uppy/aws-s3";
import ja from "@uppy/locales/lib/ja_JP";
import { useDestroyFile } from "./FileAction";

export const useUppy = (
    options = {
        csrf_token: "",
        maxFileSize: 2400 * 2 ** 20,
        maxNumberOfFiles: 1,
        minNumberOfFiles: 1,
        allowedFileTypes: [],
    }
) => {
    const restrictions = {
        maxFileSize: options.maxFileSize,
        maxNumberOfFiles: options.maxNumberOfFiles,
        minNumberOfFiles: options.minNumberOfFiles,
        allowedFileTypes: options.allowedFileTypes,
    };
    const uppy = new Uppy({
        debug: true,
        locale: ja,
        uploadComplete: "upload complete",
        restrictions,
    }).use(AwsS3, {
        companionUrl: "/",
        companionHeaders: { "X-CSRF-TOKEN": options.csrf_token },
        shouldUseMultipart: (file) => file.size > 40 * 2 ** 20,
        getUploadParameters: (file) => getParameters(file, options.csrf_token),
    });

    uppy.on("file-removed", useDestroyFile);
    return uppy;
};

const getParameters = (file, csrf_token) => {
    const headers = {
        accept: "application/json",
        "content-type": "application/json",
        "X-CSRF-TOKEN": csrf_token,
    };
    const body = {
        filename: file.name,
        contentType: file.type,
        fileSize: file.size,
    };
    return window.axios
        .post(route("signed.url"), body, { headers }) //TODO: need to fixed here route
        .then(({ data }) => ({
            method: data.method,
            url: data.url,
            fields: data.fields,
            headers: data.headers,
        }));
};
