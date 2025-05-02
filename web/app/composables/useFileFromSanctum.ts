import { STORAGE_ENPOINT } from "~~/constants/api";

export async function useFileFromSanctum(filePath: string): Promise<File> {
    return useSanctumFetch<Blob>(
        `${STORAGE_ENPOINT}/${filePath}`,
        {
            method: "GET",
            headers: {
                "Content-Type": "image/gif",
            },
        }
    ).then((response) => {
        const gifBlob = response.data.value;
        if (!gifBlob) {
            throw new Error("Failed to fetch the GIF file");
        }

        const gifFile = new File(
            [gifBlob],
            filePath.split('/').pop() || "exercise.gif",
            {
                type: "image/gif",
            }
        );
        return gifFile;
    });
}