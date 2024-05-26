import { useCallback, useEffect, useState } from 'react';

const usePageName = (pageName?: string) => {
    const [pageTitle, setPageTitle] = useState<string>('');

    const updatePageTitle = useCallback(() => {
        if (pageName !== undefined) {
            setPageTitle(`${pageName} | Rede Akiba - O Paraíso dos Otakus! | Sua Melhor Fonte de Animes (e Mangás) no Brasil!`);
        } else {
            setPageTitle('Rede Akiba - O Paraíso dos Otakus! | Sua Melhor Fonte de Animes (e Mangás) no Brasil!');
        }
    }, [pageName]);

    useEffect(() => {
        updatePageTitle();
    }, [updatePageTitle]);

    document.title = pageTitle || ''; 
};

export default usePageName;