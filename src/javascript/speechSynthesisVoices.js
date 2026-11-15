class SpeechSynthesisVoices {
    getVoices() {
        try {
            const synthesis = window.speechSynthesis;

            if (typeof synthesis?.getVoices !== "function") {
                return "API unavailable";
            }

            const voices = synthesis.getVoices();

            if (voices.length === 0) {
                return "No voices reported";
            }

            const localCount = voices.filter(voice => voice.localService).length;
            const remoteCount = voices.length - localCount;
            const languageTagCount = new Set(
                voices.map(voice => voice.lang.toLowerCase()).filter(Boolean)
            ).size;
            const formatCount = new Intl.NumberFormat("en-US");

            return [
                `${formatCount.format(voices.length)} ${voices.length === 1 ? "voice" : "voices"}`,
                `${formatCount.format(localCount)} local`,
                `${formatCount.format(remoteCount)} remote`,
                `${formatCount.format(languageTagCount)} ${languageTagCount === 1 ? "language tag" : "language tags"}`
            ].join(" · ");

        } catch (error) {
            console.error("Error reading speech synthesis voices:", error);
            return "Voice enumeration failed";
        }
    }

    onVoicesChanged(callback) {
        const synthesis = window.speechSynthesis;
        synthesis?.addEventListener?.("voiceschanged", callback);
    }
}