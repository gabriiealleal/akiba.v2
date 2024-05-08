import { useCallback, useState, useEffect } from 'react';
import axios from 'axios';

interface StreamingData {
    status: string;
    porta: string;
    porta_dj: string;
    ip: string;
    ouvintes_conectados: string;
    capa_musica: string;
    genero: string;
    musica_atual: string;
    plano_bitrate: string;
    plano_ftp: string;
    plano_ouvintes: string;
    proxima_musica: any; 
    shoutcast: string;
    titulo: string;
  }

  const useStreaming = (): StreamingData | undefined => {
    const [streamingData, setStreamingData] = useState<StreamingData>();

    const getStreamingData = useCallback(async () => {
        try {
            const response = await axios.get<StreamingData>(import.meta.env.VITE_API_STREAMING, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            setStreamingData(response.data);
        } catch (error) {
            console.error('Error ao buscar dados da API do streaming:', error);
        }
    }, []);

    useEffect(() => {
        getStreamingData();
        setInterval(() => {
            getStreamingData();
        }, 30 * 1000);
    }, []);

    return streamingData;
};

export default useStreaming;