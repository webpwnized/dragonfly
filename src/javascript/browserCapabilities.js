class BrowserCapabilities {
    getDisplayPreferences() {
        const colorScheme = window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "Dark"
            : "Light";
        const motion = window.matchMedia("(prefers-reduced-motion: reduce)").matches
            ? "Reduced motion"
            : "No motion preference";

        return `${colorScheme} · ${motion}`;
    }

    getSystemColors() {
        const probe = document.createElement("span");
        probe.hidden = true;
        document.body.appendChild(probe);

        try {
            const colors = ["Canvas", "CanvasText", "ButtonFace", "ButtonText"];

            return colors.map(color => {
                probe.style.color = "";
                probe.style.color = color;
                const value = probe.style.color
                    ? window.getComputedStyle(probe).color
                    : "Unavailable";

                return `${color} ${value}`;
            }).join(" · ");
        } finally {
            probe.remove();
        }
    }

    async getVideoDecodingSummary() {
        try {
            const result = await navigator.mediaCapabilities?.decodingInfo({
                type: "file",
                video: {
                    contentType: 'video/mp4; codecs="avc1.640028"',
                    width: 1920,
                    height: 1080,
                    bitrate: 5_000_000,
                    framerate: 30
                }
            });

            if (!result) {
                return "";
            }

            if (!result.supported) {
                return "Unsupported";
            }

            return [
                "Supported",
                `Smooth: ${result.smooth ? "Yes" : "No"}`,
                `Power efficient: ${result.powerEfficient ? "Yes" : "No"}`
            ].join(" · ");
        } catch {
            return "";
        }
    }

    async getStorageQuotaSummary() {
        try {
            const estimate = await navigator.storage?.estimate();
            const quota = estimate?.quota;

            if (!Number.isFinite(quota) || quota < 0) {
                return "";
            }

            const quotaGiB = new Intl.NumberFormat("en-US", {
                maximumFractionDigits: 2
            }).format(quota / (1024 ** 3));

            return `${quotaGiB} GiB`;
        } catch {
            return "";
        }
    }
}