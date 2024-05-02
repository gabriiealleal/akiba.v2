//Importando componentes da view
import BoasVindas from '@/interfaces/private/components/dashboard/BoasVindas';
import AvisosParaEquipe from '@/interfaces/private/components/dashboard/AvisosParaEquipe';
import AcoesRapidas from '@/interfaces/private/components/dashboard/AcoesRapidas';

//Importando hooks personalizados
import usePageName from '@/hooks/usePageName';

const Dashboard = () => {
    //Definindo o nome da página
    usePageName('Dashboard');
    
    return (
        <>
            <BoasVindas/>
            <AvisosParaEquipe/>
            <AcoesRapidas/>
        </>
    );
}

export default Dashboard;