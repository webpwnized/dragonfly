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

            return voices.map(voice => {
                const service = voice.localService ? "local" : "remote";
                const defaultLabel = voice.default ? ", default" : "";

                return `${voice.name} (${voice.lang}, ${service}${defaultLabel})`;
            }).join("; ");
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